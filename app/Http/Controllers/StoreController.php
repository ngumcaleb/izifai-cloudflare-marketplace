<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('status', 'active')
            ->withCount('products')
            ->with('products.images')
            ->latest()
            ->paginate(16);
        return view('stores.index', compact('stores'));
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
            ->withCount('favorites')
            ->orderBy('favorites_count', 'desc')
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

        // Store tenure
        $storeTenureDays = $store->created_at ? $store->created_at->diffInDays(now()) : 0;
        $tenureLabel = 'Member since ' . $storeTenureDays . ' days';

        return view('stores.show', compact(
            'store', 'products', 'categories', 'reviews',
            'starDistribution', 'avgRating', 'totalReviews',
            'totalProducts', 'topProducts', 'tenureLabel',
            'savedProductIds'
        ));
    }
}
