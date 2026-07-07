<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $totalStores = \App\Models\Store::where('status', 'active')->count();
        $totalProducts = \App\Models\Product::whereHas('store', function ($q) {
            $q->where('status', 'active');
        })->count();
        $verifiedStores = \App\Models\Store::where('status', 'active')->where('is_verified', true)->count();
        $totalServices = \App\Models\Service::active()->count();
        $totalRentals = \App\Models\RentalItem::where('status', 'published')->count();

        $categories = \App\Models\Category::whereHas('products', function ($q) {
            $q->whereHas('store', fn($sq) => $sq->where('status', 'active'));
        })->withCount(['products' => function ($q) {
            $q->whereHas('store', fn($sq) => $sq->where('status', 'active'));
        }])->orderBy('name')->get();

        $products = \App\Models\Product::active()
            ->with(['images', 'store', 'category', 'savedUsers'])
            ->inRandomOrder()
            ->take(12)
            ->get();

        $trendingProducts = \App\Models\Product::active()
            ->with(['images', 'store'])
            ->orderBy('views', 'desc')
            ->take(8)
            ->get();

        $latestProducts = \App\Models\Product::active()
            ->with(['images', 'store', 'category'])
            ->inRandomOrder()
            ->take(12)
            ->get();

        $services = \App\Models\Service::active()
            ->with(['store', 'category', 'images'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        $rentals = \App\Models\RentalItem::where('status', 'published')
            ->with(['store', 'category'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        $stores = \App\Models\Store::where('status', 'active')
            ->has('products')
            ->with(['products' => function ($q) {
                $q->with('images')->latest()->take(1);
            }])
            ->inRandomOrder()
            ->take(6)
            ->get();

        $topStores = \App\Models\Store::where('status', 'active')
            ->has('products')
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(4)
            ->get();

        $topRatedStores = \App\Models\Store::where('status', 'active')
            ->has('products')
            ->withCount('products')
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get();

        $topRatedProducts = \App\Models\Product::active()
            ->with(['images', 'store'])
            ->where('rating', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(8)
            ->get();

        $topRatedServices = \App\Models\Service::active()
            ->with(['store'])
            ->where('rating', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get();

        $trendingRentals = \App\Models\RentalItem::where('status', 'published')
            ->with(['store', 'category'])
            ->orderBy('views', 'desc')
            ->take(4)
            ->get();

        $allProductCategories = \App\Models\Category::whereHas('products', fn($q) => $q->whereHas('store', fn($s) => $s->where('status', 'active')))
            ->withCount(['products' => fn($q) => $q->whereHas('store', fn($s) => $s->where('status', 'active'))])
            ->orderBy('name')->get();

        $allServiceCategories = \App\Models\Category::whereHas('services', fn($q) => $q->whereHas('store', fn($s) => $s->where('status', 'active')))
            ->withCount(['services' => fn($q) => $q->whereHas('store', fn($s) => $s->where('status', 'active'))])
            ->orderBy('name')->get();

        $allRentalCategories = \App\Models\Category::whereHas('rentalItems', fn($q) => $q->where('status', 'published'))
            ->withCount(['rentalItems' => fn($q) => $q->where('status', 'published')])
            ->orderBy('name')->get();

        $featuredStore = \App\Models\Store::where('status', 'active')
            ->has('products')
            ->with(['products' => function ($q) {
                $q->with('images')->latest()->take(4);
            }])
            ->inRandomOrder()
            ->first();

        $savedProductIds = auth()->check()
            ? \App\Models\SavedProduct::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];

        return view('home', compact(
            'totalStores', 'totalProducts', 'verifiedStores', 'totalServices', 'totalRentals',
            'categories', 'products', 'trendingProducts', 'latestProducts',
            'services', 'rentals',
            'stores', 'topStores',
            'topRatedStores', 'topRatedProducts', 'topRatedServices', 'trendingRentals',
            'featuredStore', 'savedProductIds',
            'allProductCategories', 'allServiceCategories', 'allRentalCategories'
        ));
    }
}
