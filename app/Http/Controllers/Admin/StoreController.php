<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->status) {
            switch ($request->status) {
                case 'verified':
                    $query->where('is_verified', true)->where('status', 'active');
                    break;
                case 'pending':
                    $query->where('is_verified', false)->where('status', 'active');
                    break;
                case 'suspended':
                    $query->where('status', 'suspended');
                    break;
            }
        }

        if ($request->badge) {
            $query->where('badge', $request->badge);
        }

        $locations = Store::whereNotNull('location')->where('location', '!=', '')->distinct()->pluck('location')->sort()->values();

        $stores = $query->latest()->paginate(15)->withQueryString();
        return view('admin.stores.index', compact('stores', 'locations'));
    }

    public function show(Request $request, Store $store)
    {
        $store->load(['user', 'reviews.user', 'productReports.user', 'productReports.product']);

        $productsQuery = $store->products()->with('mainImage');

        if ($request->product_search) {
            $productsQuery->where('name', 'like', '%' . $request->product_search . '%');
        }

        if ($request->product_stock) {
            $productsQuery->where('stock_status', $request->product_stock);
        }

        $products = $productsQuery->latest()->paginate(10, ['*'], 'products_page')->withQueryString();

        return view('admin.stores.show', compact('store', 'products'));
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
            'badge' => 'nullable|string|in:Verified Seller,Trusted Store,Premium Seller,Legit Business,Top Rated'
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

    public function updateImages(Request $request, Store $store)
    {
        $request->validate([
            'logo' => 'nullable|image|max:1024',
            'banner' => 'nullable|image|max:2048',
        ]);

        $data = [];

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('r2')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('stores/logos', 'r2');
        }

        if ($request->hasFile('banner')) {
            if ($store->banner) {
                Storage::disk('r2')->delete($store->banner);
            }
            $data['banner'] = $request->file('banner')->store('stores/banners', 'r2');
        }

        $store->update($data);

        return back()->with('success', 'Store images updated successfully.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Store deleted from platform.');
    }
}
