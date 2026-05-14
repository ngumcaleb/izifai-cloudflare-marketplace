<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    private function getOrCreateStore()
    {
        $user = auth()->user();
        $store = $user->store;

        if (!$store) {
            $store = Store::create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Store",
                'slug' => Str::slug($user->name . ' store') . '-' . Str::random(5),
                'whatsapp_number' => $user->phone ?? '000000000',
            ]);
        }

        return $store;
    }

    public function dashboard()
    {
        $store = $this->getOrCreateStore();
        $products = $store->products()->with(['images', 'category'])->latest()->get();
        $user = auth()->user();
        $productIds = $store->products()->pluck('id');
        
        $adRequests = \App\Models\AdvertisementRequest::with('product')
            ->where('store_id', $store->id)
            ->latest()
            ->get();
            
        $stats = [
            'total_views' => $store->products()->sum('views'),
            'daily_views' => \App\Models\ProductEvent::where('store_id', $store->id)->where('type', 'view')->where('created_at', '>=', now()->startOfDay())->count(),
            'total_contacts' => \App\Models\ProductEvent::where('store_id', $store->id)->whereIn('type', ['whatsapp_click', 'call_click'])->count(),
            'daily_contacts' => \App\Models\ProductEvent::where('store_id', $store->id)->whereIn('type', ['whatsapp_click', 'call_click'])->where('created_at', '>=', now()->startOfDay())->count(),
            'saved_count' => \App\Models\SavedProduct::whereIn('product_id', $productIds)->count(),
        ];

        $mostViewed = $store->products()->with(['images', 'category'])->orderBy('views', 'desc')->take(5)->get();

        $mostContacted = \App\Models\ProductEvent::whereIn('product_id', $productIds)
            ->whereIn('type', ['whatsapp_click', 'call_click'])
            ->selectRaw('product_id, count(*) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->load('product.images');

        $mostSaved = \App\Models\SavedProduct::whereIn('product_id', $productIds)
            ->selectRaw('product_id, count(*) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->load('product.images');

        return view('seller.dashboard', compact('store', 'products', 'user', 'adRequests', 'stats', 'mostViewed', 'mostContacted', 'mostSaved'));
    }

    public function storeSettings()
    {
        $store = $this->getOrCreateStore();
        return view('seller.store-settings', compact('store'));
    }

    public function updateStoreSettings(Request $request)
    {
        $store = $this->getOrCreateStore();

        $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'business_email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:1024',
            'banner' => 'nullable|image|max:2048',
            'profile_photo' => 'nullable|image|max:1024',
            'open_hours' => 'nullable|string',
            'social_platforms.*' => 'nullable|string',
            'social_urls.*' => 'nullable|url|max:500',
        ]);

        $data = $request->only(['name', 'whatsapp_number', 'location', 'business_email', 'description']);

        // Build social_links array
        $socialLinks = [];
        if ($request->has('social_platforms')) {
            foreach ($request->social_platforms as $i => $platform) {
                if (!empty($platform) && !empty($request->social_urls[$i])) {
                    $socialLinks[] = [
                        'platform' => $platform,
                        'url' => $request->social_urls[$i],
                    ];
                }
            }
        }
        $data['social_links'] = $socialLinks;
        $data['open_hours'] = $request->open_hours;
        $user = auth()->user();
        $user->name = $request->user_name;
        if ($request->has('default_page')) {
            $user->default_page = $request->default_page;
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        if ($request->hasFile('profile_photo')) {
            $user->profile_photo_path = $request->file('profile_photo')->store('profile_photos', 'public');
        }
        
        $user->save();

        $store->update($data);

        return back()->with('success', 'Store settings updated successfully!');
    }

    public function reviews()
    {
        $store = $this->getOrCreateStore();
        $reviews = $store->reviews()->with('user')->latest()->get();

        $starDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $percentage = $reviews->count() > 0 ? ($count / $reviews->count()) * 100 : 0;
            $starDistribution[$i] = ['count' => $count, 'percentage' => $percentage];
        }
        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
        $totalReviews = $reviews->count();

        return view('seller.reviews.index', compact('reviews', 'starDistribution', 'avgRating', 'totalReviews'));
    }
}
