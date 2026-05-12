<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
        }

        $stores = $query->latest()->paginate(15)->withQueryString();
        return view('admin.stores.index', compact('stores'));
    }

    public function show(Store $store)
    {
        $store->load(['user', 'products.images', 'reviews.user', 'productReports.user', 'productReports.product']);
        return view('admin.stores.show', compact('store'));
    }

    public function verify(Request $request, Store $store)
    {
        $store->update([
            'is_verified' => true,
        ]);

        return back()->with('success', 'Store verified successfully.');
    }

    public function updateBadge(Request $request, Store $store)
    {
        $request->validate([
            'badge' => 'nullable|string|in:Verified Seller,Trusted Store,Premium Seller'
        ]);

        $store->update([
            'badge' => $request->badge,
        ]);

        return back()->with('success', 'Store badge updated successfully.');
    }

    public function toggleStatus(Store $store)
    {
        $newStatus = $store->status === 'active' ? 'suspended' : 'active';
        $store->update(['status' => $newStatus]);

        // Also suspend/activate the owner user
        $store->user->update(['status' => $newStatus]);

        return back()->with('success', 'Store and owner account ' . $newStatus . ' successfully.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Store deleted from platform.');
    }
}
