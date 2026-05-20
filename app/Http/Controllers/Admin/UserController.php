<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['store' => function ($q) {
            $q->withCount(['products' => function ($pq) {
                $pq->whereHas('store', fn($sq) => $sq->where('status', 'active'));
            }]);
        }]);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user->load('store');
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'admin' && $request->role !== 'admin') {
            return back()->with('error', 'Cannot change an administrator\'s role.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:buyer,seller,admin',
            'status' => 'required|in:active,suspended',
            'profile_photo' => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'role', 'status']);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('r2')->delete($user->profile_photo_path);
            }
            $data['profile_photo_path'] = $request->file('profile_photo')->store('profile_photos', 'r2');
        }

        // If changing to seller without a store, create one
        if ($data['role'] === 'seller' && !$user->store) {
            Store::create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Store",
                'slug' => Str::slug($user->name . ' store') . '-' . Str::random(5),
                'whatsapp_number' => $user->phone,
            ]);
        }

        // Sync store status with user status
        if ($user->store && $data['status'] !== $user->status) {
            $user->store->update(['status' => $data['status']]);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend an administrator.');
        }

        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        // If user is a seller, also toggle their store status
        if ($user->store) {
            $user->store->update(['status' => $newStatus]);
        }

        return back()->with('success', 'User account ' . $newStatus . ' successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete an administrator.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
