<?php

namespace App\Http\Controllers;

use App\Models\CommandTechMember;
use Illuminate\Http\Request;

class ComandTechController extends Controller
{
    /**
     * Display the committee members page.
     */
    public function showCommittee()
    {
        $members = CommandTechMember::where('type', 'committee')
                                    ->where('status', 'Active')
                                    ->get();
        return view('client.committee', compact('members'));
    }

    /**
     * Display the technical team members page.
     */
    public function showTechnicalTeam()
    {
        $members = CommandTechMember::where('type', 'technical')
                                    ->where('status', 'Active')
                                    ->get();
        return view('client.technicalteam', compact('members'));
    }

    /* ============================================================
       ADMIN METHODS
    ============================================================ */

    /**
     * Display all members (Admin).
     */
    public function index()
    {
        $members = CommandTechMember::latest()->paginate(10);
        return view('admin.committee.index', compact('members'));
    }

    /**
     * Show form to create new member.
     */
    public function create()
    {
        return view('admin.addmember');
    }

    /**
     * Store new member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'email' => 'required|email|unique:committee_members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'nic' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Active,Inactive',
            'type' => 'required|in:committee,technical',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/com_memberprofile'), $photoName);
            $photoPath = 'uploads/com_memberprofile/' . $photoName;
        }

        CommandTechMember::create([
            'full_name' => $request->full_name,
            'purpose' => $request->purpose,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nic' => $request->nic,
            'photo_path' => $photoPath,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.committee.index')->with('success', 'Member added successfully.');
    }

    /**
     * Show form to edit member.
     */
    public function edit($id)
    {
        $member = CommandTechMember::findOrFail($id);
        return view('admin.addmember', compact('member'));
    }

    /**
     * Update member.
     */
    public function update(Request $request, $id)
    {
        $member = CommandTechMember::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'email' => 'required|email|unique:committee_members,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'nic' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Active,Inactive',
            'type' => 'required|in:committee,technical',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($member->photo_path && file_exists(public_path($member->photo_path))) {
                unlink(public_path($member->photo_path));
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/com_memberprofile'), $photoName);
            $member->photo_path = 'uploads/com_memberprofile/' . $photoName;
        }

        $member->update([
            'full_name' => $request->full_name,
            'purpose' => $request->purpose,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nic' => $request->nic,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.committee.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Delete member.
     */
    public function destroy($id)
    {
        $member = CommandTechMember::findOrFail($id);

        // Delete photo
        if ($member->photo_path && file_exists(public_path($member->photo_path))) {
            unlink(public_path($member->photo_path));
        }

        $member->delete();

        return redirect()->route('admin.committee.index')->with('success', 'Member deleted successfully.');
    }
}
