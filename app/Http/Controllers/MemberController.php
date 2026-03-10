<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    /**
     * Show the joinus page with initial CAPTCHA.
     */
    public function joinUs()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);
        session()->put('math_captcha', $a + $b);
        return view('client.joinus', compact('a', 'b'));
    }

    /**
     * Store a newly created membership application.
     */
    public function store(Request $request)
    {
        // CAPTCHA check
        if ((int)$request->captcha_answer !== (int)session('math_captcha')) {
            return response()->json([
                'success' => false,
                'errors' => ['captcha_answer' => ['The CAPTCHA you entered is incorrect. Please check it and try again.']]
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'nic' => 'required|string|max:20',
            'phone' => 'required|string', // Validated in JS, stored as E.164
            'email' => 'required|email|unique:members,email',
            'address' => 'required|string',
            'purpose' => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'verification_document' => 'required|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle File Uploads
        $photo = $request->file('photo');
        $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('Member/photo'), $photoName);
        $photoPath = 'Member/photo/' . $photoName;

        $doc = $request->file('verification_document');
        $docName = uniqid() . '.' . $doc->getClientOriginalExtension();
        $doc->move(public_path('Member/documents'), $docName);
        $docPath = 'Member/documents/' . $docName;

        // Create Member
        Member::create([
            'full_name' => $request->full_name,
            'nic' => $request->nic,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'purpose' => $request->purpose,
            'photo_path' => $photoPath,
            'verification_document_path' => $docPath,
            'status' => 'Pending',
        ]);

        // Clear CAPTCHA
        session()->forget('math_captcha');

        return response()->json([
            'success' => true,
            'message' => 'Your application has been submitted successfully and is currently under review.'
        ]);
    }

    /**
     * Admin: List all members.
     */
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    /**
     * Admin: Show member details.
     */
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.members.show', compact('member'));
    }

    /**
     * Admin: Update member status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected,Pending'
        ]);

        $member = Member::findOrFail($id);
        $member->update(['status' => $request->status]);

        return back()->with('success', 'Member status updated to ' . $request->status);
    }

    /**
     * Admin: Delete member.
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        
        // Delete files
        if ($member->photo_path && file_exists(public_path($member->photo_path))) {
            unlink(public_path($member->photo_path));
        }
        if ($member->verification_document_path && file_exists(public_path($member->verification_document_path))) {
            unlink(public_path($member->verification_document_path));
        }
        
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully.');
    }

    /**
     * Securely download/preview verification document.
     */
    public function downloadDocument($id)
    {
        $member = Member::findOrFail($id);
        
        $filePath = public_path($member->verification_document_path);
        if (!$member->verification_document_path || !file_exists($filePath)) {
            abort(404);
        }
        return response()->download($filePath);
    }

    /**
     * Securely serve photo.
     */
    public function showPhoto($id)
    {
        $member = Member::findOrFail($id);
        
        $filePath = public_path($member->photo_path);
        if (!$member->photo_path || !file_exists($filePath)) {
            abort(404);
        }
        return response()->file($filePath);
    }
}
