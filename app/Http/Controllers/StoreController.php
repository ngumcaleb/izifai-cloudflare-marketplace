<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::where('status', 'active')
            ->withCount(['products', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->with('products.images');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('products.category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'rating':
                $query->orderByDesc('reviews_avg_rating');
                break;
            case 'products':
                $query->orderByDesc('products_count');
                break;
            default:
                $query->latest();
                break;
        }

        $stores = $query->paginate(16)->withQueryString();

        // Categories that have products in active stores
        $categoryIds = \App\Models\Product::whereHas('store', function ($q) {
            $q->where('status', 'active');
        })->distinct()->pluck('category_id');
        $categories = \App\Models\Category::whereIn('id', $categoryIds)->get();

        // Hero stats
        $totalStores = Store::where('status', 'active')->count();
        $totalProducts = \App\Models\Product::whereHas('store', function ($q) {
            $q->where('status', 'active');
        })->count();

        return view('stores.index', compact('stores', 'categories', 'totalStores', 'totalProducts'));
    }
    public function show(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        $productsQuery = $store->products()->with(['images', 'category']);

        if ($request->filled('search')) {
            $productsQuery->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $productsQuery->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'price_low') {
                $productsQuery->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_high') {
                $productsQuery->orderBy('price', 'desc');
            } else {
                $productsQuery->latest();
            }
        } else {
            $productsQuery->latest();
        }

        $products = $productsQuery->paginate(12)->withQueryString();

        $categories = \App\Models\Category::whereHas('products', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->get();

        $reviews = $store->reviews()->with('user')->latest()->get();

        $starDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $percentage = $reviews->count() > 0 ? ($count / $reviews->count()) * 100 : 0;
            $starDistribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
        $totalReviews = $reviews->count();
        $totalProducts = $store->products()->count();

        // Top products by favorites for bento grid
        $topProducts = $store->products()
            ->with('images')
            ->withCount('savedUsers')
            ->orderBy('saved_users_count', 'desc')
            ->take(5)
            ->get();

        if ($topProducts->count() < 5) {
            $topProducts = $store->products()
                ->with('images')
                ->latest()
                ->take(5)
                ->get();
        }

        // Saved product IDs for favorite buttons
        $savedProductIds = [];
        if (auth()->check()) {
            $savedProductIds = \App\Models\SavedProduct::where('user_id', auth()->id())
                ->whereIn('product_id', $store->products()->pluck('id'))
                ->pluck('product_id')
                ->toArray();
        }

        // Services
        $servicesQuery = $store->services()->active()->with(['images', 'mainImage', 'category']);

        if ($request->filled('service_search')) {
            $ss = $request->service_search;
            $servicesQuery->where(function ($q) use ($ss) {
                $q->where('name', 'like', '%' . $ss . '%')
                  ->orWhere('description', 'like', '%' . $ss . '%');
            });
        }

        $services = $servicesQuery->latest()->take(12)->get();
        $totalServices = $store->services()->active()->count();

        // Rentals
        $rentalsQuery = $store->rentalItems()->where('status', 'published')->with(['category']);

        if ($request->filled('rental_search')) {
            $rs = $request->rental_search;
            $rentalsQuery->where(function ($q) use ($rs) {
                $q->where('name', 'like', '%' . $rs . '%')
                  ->orWhere('description', 'like', '%' . $rs . '%');
            });
        }

        $rentals = $rentalsQuery->latest()->take(12)->get();
        $totalRentals = $store->rentalItems()->where('status', 'published')->count();

        // Combined categories for all listing types
        $serviceCategoryIds = \App\Models\Category::whereHas('services', fn($q) => $q->where('store_id', $store->id))->pluck('id');
        $rentalCategoryIds = \App\Models\Category::whereHas('rentalItems', fn($q) => $q->where('store_id', $store->id))->pluck('id');
        $allCategoryIds = $categories->pluck('id')->merge($serviceCategoryIds)->merge($rentalCategoryIds)->unique();
        $allCategories = \App\Models\Category::whereIn('id', $allCategoryIds)->get();

        $storeCategories = $store->storeCategories()->with('children')->whereNull('parent_id')->get();

        $totalItems = $totalProducts + $totalServices + $totalRentals;

        // Store tenure
        $joinedDate = $store->created_at ? $store->created_at->format('M d, Y') : 'N/A';

        return view('stores.show', compact(
            'store', 'products', 'categories', 'reviews',
            'starDistribution', 'avgRating', 'totalReviews',
            'totalProducts', 'topProducts', 'joinedDate',
            'savedProductIds', 'services', 'totalServices',
            'rentals', 'totalRentals', 'allCategories', 'storeCategories', 'totalItems'
        ));
    }

    public function searchJson(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $query = $store->products()->with('images');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $products = $query->latest()->take(6)->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => $p->price,
                'old_price' => $p->old_price,
                'image' => $p->images->first()?->path,
                'category' => $p->category?->name,
            ];
        });

        return response()->json($products);
    }
}
