<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportingDocument;
use Illuminate\Http\Request;

class SupportingDocumentController extends Controller
{
    public function index()
    {
        $documents = SupportingDocument::latest()->get();
        return view('admin.managepdf', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('uploads/documents'), $fileName);

            SupportingDocument::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => 'uploads/documents/' . $fileName,
                'file_type' => $extension,
            ]);

            return back()->with('success', 'Document uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload document.');
    }

    public function destroy($id)
    {
        $document = SupportingDocument::findOrFail($id);
        
        if (file_exists(public_path($document->file_path))) {
            unlink(public_path($document->file_path));
        }
        
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
