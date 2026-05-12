<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['store']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
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
