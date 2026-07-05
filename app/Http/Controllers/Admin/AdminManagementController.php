<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::query();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $admins = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20)
            ->withQueryString();

        return view('admin.admin-management.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-management.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,support',
        ]);

        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        AuditLogger::log('admin.created', "Created admin #{$admin->id}: {$admin->name} ({$admin->email})", $admin);

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin account created successfully.');
    }

    public function edit(Admin $adminManagement)
    {
        return view('admin.admin-management.edit', ['admin' => $adminManagement]);
    }

    public function update(Request $request, Admin $adminManagement)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $adminManagement->id,
            'role' => 'required|in:super_admin,admin,support',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];

        if ($data['password']) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $oldValues = $adminManagement->only(['name', 'email', 'role']);
        $adminManagement->update($updateData);
        $newValues = $adminManagement->only(['name', 'email', 'role']);

        AuditLogger::log('admin.updated', "Updated admin #{$adminManagement->id}: {$adminManagement->name}", $adminManagement, $oldValues, $newValues);

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin account updated successfully.');
    }

    public function destroy(Admin $adminManagement)
    {
        if ($adminManagement->id === auth('admin')->id()) {
            return redirect()->route('admin.admin-management.index')
                ->with('error', 'You cannot delete your own account.');
        }

        AuditLogger::log('admin.deleted', "Deleted admin #{$adminManagement->id}: {$adminManagement->name} ({$adminManagement->email})");

        $adminManagement->delete();

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin account deleted successfully.');
    }
}
