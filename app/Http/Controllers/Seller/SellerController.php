<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SavedProduct;
use App\Models\Store;
use App\Models\StoreReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function dashboard()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $store->loadCount(['products', 'reviews']);

        $products = $store->products()->with('images')->latest()->get();

        $totalViews = $products->sum('views');
        $dailyViews = $products->filter(fn($p) => $p->updated_at && $p->updated_at->isToday())->sum('views');

        $savedCount = SavedProduct::whereIn('product_id', $products->pluck('id'))->count();

        $stats = [
            'total_views' => $totalViews,
            'daily_views' => $dailyViews,
            'total_contacts' => 0,
            'daily_contacts' => 0,
            'saved_count' => $savedCount,
        ];

        $mostViewed = $products->sortByDesc('views')->take(5);

        $mostSaved = SavedProduct::selectRaw('product_id, COUNT(*) as total')
            ->whereIn('product_id', $products->pluck('id'))
            ->groupBy('product_id')
            ->with('product.images')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'store', 'stats', 'products', 'mostViewed', 'mostSaved'
        ))->with('mostContacted', collect());
    }

    public function createStore()
    {
        if (auth()->user()->store) {
            return redirect()->route('seller.store.settings')
                ->with('info', 'You already have a store. Edit it here.');
        }

        return view('seller.store-create');
    }

    public function storeStore(Request $request)
    {
        if (auth()->user()->store) {
            return redirect()->route('seller.store.settings')
                ->with('error', 'You already have a store.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['name', 'description', 'location', 'whatsapp_number', 'business_email']);

        $slug = Str::slug($request->name);
        $original = $slug;
        $counter = 1;
        while (Store::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['user_id'] = auth()->id();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('store-logos', 'r2');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('store-banners', 'r2');
        }

        $store = Store::create($data);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Your store has been created! Start adding products.');
    }

    public function storeSettings()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        return view('seller.store-settings', compact('store'));
    }

    public function updateStoreSettings(Request $request)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'open_hours' => 'nullable|string|max:500',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'nullable|string|max:50',
            'social_links.*.url' => 'nullable|url|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['name', 'description', 'location', 'whatsapp_number', 'business_email', 'open_hours']);

        if ($request->has('social_links')) {
            $data['social_links'] = array_values(array_filter($request->social_links, fn($link) => !empty($link['platform']) || !empty($link['url'])));
        }

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('r2')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('store-logos', 'r2');
        }

        if ($request->hasFile('banner')) {
            if ($store->banner) {
                Storage::disk('r2')->delete($store->banner);
            }
            $data['banner'] = $request->file('banner')->store('store-banners', 'r2');
        }

        $store->update($data);

        return redirect()->route('seller.store.settings')->with('success', 'Store updated successfully.');
    }

    public function reviews()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $reviews = StoreReview::where('store_id', $store->id)
            ->with('user')
            ->latest()
            ->get();

        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
        $totalReviews = $reviews->count();

        $starDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $starDistribution[$i] = [
                'count' => $count,
                'percentage' => $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0,
            ];
        }

        return view('seller.reviews.index', compact(
            'reviews', 'avgRating', 'totalReviews', 'starDistribution'
        ));
    }
}
