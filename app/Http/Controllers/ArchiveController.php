<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArchiveController extends Controller
{
    /**
     * Show the archiving submission form.
     */
    public function show()
    {
        $addressSetting = \App\Models\SiteSetting::where('key', 'submission_address')->first();
        $address = $addressSetting ? $addressSetting->value : "The TIC Archives Office,\n123 Heritage Lane, Jaffna,\nSri Lanka.";
        
        return view('client.archiving', compact('address'));
    }

    /**
     * Store a new archiving submission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'required|string|max:20',
            'author_name' => 'required|string|max:255',
            'doc_type' => 'required|in:pdf,book',
            'file_upload' => 'nullable|required_if:doc_type,pdf|mimes:pdf|max:10240', // 10MB limit
            'description' => 'required|string',
        ], [
            'file_upload.required_if' => 'Please upload the PDF file for digital documentation.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $uploadPath = public_path('uploads/docs');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $fileName);
            $filePath = 'uploads/docs/' . $fileName;
        }

        Archive::create([
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_phone' => $request->donor_phone,
            'author_name' => $request->author_name,
            'doc_type' => $request->doc_type,
            'file_path' => $filePath,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your documentation details have been submitted successfully.'
        ]);
    }

    /**
     * Admin: List all archiving submissions.
     */
    public function index()
    {
        $archives = Archive::latest()->paginate(15);
        $addressSetting = \App\Models\SiteSetting::where('key', 'submission_address')->first();
        $address = $addressSetting ? $addressSetting->value : "The TIC Archives Office,\n123 Heritage Lane, Jaffna,\nSri Lanka.";

        return view('admin.viewarchives', compact('archives', 'address'));
    }

    /**
     * Admin: Download the archived document.
     */
    public function download($id)
    {
        $archive = Archive::findOrFail($id);
        
        if ($archive->doc_type !== 'pdf' || !$archive->file_path) {
            return back()->with('error', 'No digital file available for this submission.');
        }

        $filePath = public_path($archive->file_path);
        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found on server.');
        }

        return response()->download($filePath);
    }

    /**
     * Admin: Update site setting.
     */
    public function updateSetting(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string',
        ]);

        \App\Models\SiteSetting::updateOrCreate(
            ['key' => $request->key],
            ['value' => $request->value]
        );

        return back()->with('success', 'Setting updated successfully.');
    }

    /**
     * Admin: Toggle status of archiving submission.
     */
    public function updateStatus($id)
    {
        $archive = Archive::findOrFail($id);
        $newStatus = ($archive->status === 'pending') ? 'archived' : 'pending';
        
        $archive->update(['status' => $newStatus]);

        return back()->with('success', 'Status updated to ' . ucfirst($newStatus) . ' successfully.');
    }
}
