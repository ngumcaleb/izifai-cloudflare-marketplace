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

        $stores = \App\Models\Store::where('status', 'active')
            ->with(['products' => function ($q) {
                $q->with('images')->latest()->take(1);
            }])
            ->inRandomOrder()
            ->take(6)
            ->get();

        $featuredStore = \App\Models\Store::where('status', 'active')
            ->with(['products' => function ($q) {
                $q->with('images')->latest()->take(4);
            }])
            ->inRandomOrder()
            ->first();

        $savedProductIds = auth()->check()
            ? \App\Models\SavedProduct::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];

        return view('home', compact(
            'totalStores', 'totalProducts', 'verifiedStores',
            'categories', 'products', 'stores',
            'featuredStore', 'savedProductIds'
        ));
    }
}
