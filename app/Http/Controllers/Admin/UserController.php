<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['store' => function ($q) {
            $q->withCount(['products' => function ($pq) {
                $pq->whereHas('store', fn ($sq) => $sq->where('status', 'active'));
            }]);
        }]);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            });
        }

        if ($request->role) {
            if ($request->role === 'seller') {
                $query->whereHas('store');
            } elseif ($request->role === 'buyer') {
                $query->whereDoesntHave('store');
            } else {
                $query->where('role', $request->role);
            }
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has_store === 'yes') {
            $query->whereHas('store');
        } elseif ($request->has_store === 'no') {
            $query->whereDoesntHave('store');
        }

        $perPage = $request->input('per_page', 20);
        $users = $query->latest()->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user->load('store');

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === Role::Superadmin && $request->role !== 'Superadmin') {
            return back()->with('error', 'Cannot change a Super Administrator\'s role.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:Superadmin,User',
            'status' => 'required|in:active,suspended',
            'profile_photo' => 'nullable|image|max:1024',
            'has_store' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'role', 'status']);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('r2')->delete($user->profile_photo_path);
            }
            $data['profile_photo_path'] = $request->file('profile_photo')->store('profile_photos', 'r2');
        }

        // Create a store for the user if requested and they don't have one
        if ($request->boolean('has_store') && ! $user->store) {
            Store::create([
                'user_id' => $user->id,
                'name' => $user->name."'s Store",
                'slug' => Str::slug($user->name.' store').'-'.Str::random(5),
                'whatsapp_number' => $user->phone,
            ]);
        }

        // Remove store if unchecked
        if (! $request->boolean('has_store') && $user->store) {
            $user->store->delete();
        }

        // Sync store status with user status
        if ($user->store && $data['status'] !== $user->status) {
            $user->store->update(['status' => $data['status']]);
        }

        $oldValues = $user->only(['name', 'email', 'phone', 'role', 'status']);
        $user->update($data);
        $newValues = $user->only(['name', 'email', 'phone', 'role', 'status']);

        AuditLogger::log('user.updated', "Updated user #{$user->id}: {$user->name}", $user, $oldValues, $newValues);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->role === Role::Superadmin) {
            return back()->with('error', 'Cannot suspend a Super Administrator.');
        }

        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $oldStatus = $user->status;
        $user->update(['status' => $newStatus]);

        if ($user->store) {
            $user->store->update(['status' => $newStatus]);
        }

        AuditLogger::log('user.status_toggled', "User #{$user->id}: status {$oldStatus} → {$newStatus}", $user, ['status' => $oldStatus], ['status' => $newStatus]);

        return back()->with('success', 'User account '.$newStatus.' successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role === Role::Superadmin) {
            return back()->with('error', 'Cannot delete a Super Administrator.');
        }
        $user->delete();
        AuditLogger::log('user.deleted', "Deleted user #{$user->id}: {$user->name}");

        return back()->with('success', 'User deleted successfully.');
    }
}
