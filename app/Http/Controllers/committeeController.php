<?php

namespace App\Http\Controllers;

use App\Models\CommitteeMember;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    /**
     * Admin: List all committee members.
     */
    public function index()
    {
        $members = CommitteeMember::where('status', 'Active')->latest()->paginate(10);
        return view('admin.committee.index', compact('members'));
    }

    /**
     * Admin: Show create committee member form.
     */
    public function create()
    {
        return view('admin.committee.create');
    }

    /**
     * Admin: Store new committee member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'email' => 'required|email|unique:committee_members,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'nic' => 'nullable|string|max:20',
            'photo_path' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_path')) {
            $photo = $request->file('photo_path');
            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/com_memberprofile'), $photoName);
            $photoPath = 'uploads/com_memberprofile/' . $photoName;
        }

        CommitteeMember::create([
            'full_name' => $request->full_name,
            'purpose' => $request->purpose,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nic' => $request->nic,
            'photo_path' => $photoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.committee.index')->with('success', 'Committee member added successfully.');
    }

    /**
     * Admin: Show edit committee member form.
     */
    public function edit($id)
    {
        $member = CommitteeMember::findOrFail($id);
        return view('admin.committee.edit', compact('member'));
    }

    /**
     * Admin: Update committee member.
     */
    public function update(Request $request, $id)
    {
        $member = CommitteeMember::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'email' => 'required|email|unique:committee_members,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'nic' => 'nullable|string|max:20',
            'photo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        $data = $request->only(['full_name', 'purpose', 'email', 'phone', 'address', 'nic', 'status']);

        if ($request->hasFile('photo_path')) {
            if ($member->photo_path && file_exists(public_path($member->photo_path))) {
                unlink(public_path($member->photo_path));
            }
            $photo = $request->file('photo_path');
            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/com_memberprofile'), $photoName);
            $data['photo_path'] = 'uploads/com_memberprofile/' . $photoName;
        } elseif ($request->has('remove_photo') && $request->remove_photo == 1) {
            // Remove the photo if checkbox is checked and no new photo was uploaded
            if ($member->photo_path && file_exists(public_path($member->photo_path))) {
                unlink(public_path($member->photo_path));
            }
            $data['photo_path'] = null; // Update database to null
        }

        $member->update($data);

        return redirect()->route('admin.committee.index')->with('success', 'Committee member updated successfully.');
    }

    /**
     * Admin: Delete committee member.
     */
    public function destroy($id)
    {
        $member = CommitteeMember::findOrFail($id);
        
        if ($member->photo_path && file_exists(public_path($member->photo_path))) {
            unlink(public_path($member->photo_path));
        }
        
        $member->delete();

        return redirect()->route('admin.committee.index')->with('success', 'Committee member deleted successfully.');
    }

    /**
     * Client: Display all active committee members.
     */
    public function show()
    {
        $members = CommitteeMember::where('status', 'Active')->get();
        return view('client.committee', compact('members'));
    }
}
