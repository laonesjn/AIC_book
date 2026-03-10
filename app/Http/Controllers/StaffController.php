<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Services\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function __construct(private PasswordService $passwordService) {}

    public function index()
    {
        $staff = Admin::where('role', 'staff')->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'permissions' => 'nullable|array',
        ]);

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role = 'staff';
        $admin->permissions = $request->permissions;
        $admin->save();

        return redirect()->route('admin.staff.index')->with('success', 'Staff created successfully.');
    }

    public function edit(Admin $staff)
    {
        if ($staff->role !== 'staff') {
            return redirect()->route('admin.staff.index')->with('error', 'Cannot edit non-staff user.');
        }
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Admin $staff)
    {
        if ($staff->role !== 'staff') {
            return redirect()->route('admin.staff.index')->with('error', 'Cannot update non-staff user.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $staff->id,
            'password' => 'nullable|string|min:8',
            'permissions' => 'nullable|array',
        ]);

        $staff->name = $request->name;
        $staff->email = $request->email;
        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }
        $staff->permissions = $request->permissions;
        $staff->save();

        return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(Admin $staff)
    {
        if ($staff->role !== 'staff') {
            return redirect()->route('admin.staff.index')->with('error', 'Cannot delete non-staff user.');
        }
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
    }
}
