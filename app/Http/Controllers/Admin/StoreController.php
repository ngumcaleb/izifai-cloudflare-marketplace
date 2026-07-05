<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\ProductReview;
use App\Models\ServiceReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

        if ($request->is_featured !== null && $request->is_featured !== '') {
            $query->where('is_featured', $request->is_featured);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $locations = Store::whereNotNull('location')->where('location', '!=', '')->distinct()->pluck('location')->sort()->values();

        $perPage = $request->input('per_page', 15);
        $stores = $query->latest()->paginate($perPage)->withQueryString();
        return view('admin.stores.index', compact('stores', 'locations'));
    }

    public function show(Request $request, Store $store)
    {
        $store->load(['user.wallet', 'reviews.user']);

        // Stats
        $productCount = $store->products()->count();
        $serviceCount = $store->services()->count();
        $rentalCount = $store->rentalItems()->count();
        $reviewCount = $store->reviews()->count();
        $avgRating = $store->reviews()->avg('rating');

        // Wallet
        $wallet = $store->user->wallet;
        $recentTransactions = $wallet?->transactions()->latest()->limit(8)->get() ?? collect();

        // Products
        $productsQuery = $store->products()->with('mainImage');

        if ($request->product_search) {
            $productsQuery->where('name', 'like', '%' . $request->product_search . '%');
        }

        if ($request->product_stock) {
            $productsQuery->where('stock_status', $request->product_stock);
        }

        $products = $productsQuery->latest()->paginate(10, ['*'], 'products_page')->withQueryString();

        // Services
        $servicesQuery = $store->services()->with('mainImage', 'images', 'category');
        if ($request->service_search) {
            $servicesQuery->where('name', 'like', '%' . $request->service_search . '%');
        }
        if ($request->service_status) {
            $servicesQuery->where('status', $request->service_status);
        }
        $services = $servicesQuery->latest()->paginate(10, ['*'], 'services_page')->withQueryString();

        // Service reviews count per service
        $serviceReviewCounts = ServiceReview::select('service_id', DB::raw('count(*) as total'))
            ->whereIn('service_id', $store->services()->pluck('id'))
            ->groupBy('service_id')
            ->pluck('total', 'service_id');

        // Rentals
        $rentalsQuery = $store->rentalItems()->with('category');
        if ($request->rental_search) {
            $rentalsQuery->where('name', 'like', '%' . $request->rental_search . '%');
        }
        if ($request->rental_status) {
            $rentalsQuery->where('status', $request->rental_status);
        }
        $rentals = $rentalsQuery->latest()->paginate(10, ['*'], 'rentals_page')->withQueryString();

        // Product reviews
        $productReviewCount = ProductReview::whereIn('product_id', $store->products()->pluck('id'))->count();
        $recentProductReviews = ProductReview::with('user')
            ->whereIn('product_id', $store->products()->pluck('id'))
            ->latest()
            ->limit(5)
            ->get();

        // Service reviews
        $recentServiceReviews = ServiceReview::with('user')
            ->whereIn('service_id', $store->services()->pluck('id'))
            ->latest()
            ->limit(5)
            ->get();

        // Store reviews
        $storeReviewsQuery = $store->reviews()->with('user');
        $storeReviews = $storeReviewsQuery->latest()->paginate(10, ['*'], 'reviews_page')->withQueryString();

        return view('admin.stores.show', compact(
            'store', 'wallet', 'recentTransactions',
            'productCount', 'serviceCount', 'rentalCount', 'reviewCount', 'avgRating',
            'products', 'services', 'rentals',
            'serviceReviewCounts', 'productReviewCount',
            'recentProductReviews', 'recentServiceReviews',
            'storeReviews'
        ));
    }

    public function verify(Request $request, Store $store)
    {
        $store->update([
            'is_verified' => true,
        ]);

        AuditLogger::log('store.verified', "Verified store #{$store->id}: {$store->name}", $store);

        return back()->with('success', 'Store verified successfully.');
    }

    public function updateBadge(Request $request, Store $store)
    {
        $request->validate([
            'badge' => 'nullable|string|in:Verified Seller,Trusted Store,Premium Seller,Legit Business,Top Rated'
        ]);

        $oldBadge = $store->badge;
        $store->update([
            'badge' => $request->badge,
        ]);

        AuditLogger::log('store.badge_updated', "Store #{$store->id}: badge '{$oldBadge}' → '{$request->badge}'", $store, ['badge' => $oldBadge], ['badge' => $request->badge]);

        return back()->with('success', 'Store badge updated successfully.');
    }

    public function toggleStatus(Store $store)
    {
        $oldStatus = $store->status;
        $newStatus = $store->status === 'active' ? 'suspended' : 'active';
        $store->update(['status' => $newStatus]);

        // Also suspend/activate the owner user
        $store->user->update(['status' => $newStatus]);

        AuditLogger::log('store.status_toggled', "Store #{$store->id}: status {$oldStatus} → {$newStatus}", $store, ['status' => $oldStatus], ['status' => $newStatus]);

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

        AuditLogger::log('store.images_updated', "Updated images for store #{$store->id}: {$store->name}", $store);

        return back()->with('success', 'Store images updated successfully.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        AuditLogger::log('store.deleted', "Deleted store #{$store->id}: {$store->name}");
        return redirect()->route('admin.stores.index')->with('success', 'Store deleted from platform.');
    }
}
