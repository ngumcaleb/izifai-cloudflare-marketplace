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

        $featuredProducts = \App\Models\Product::active()
            ->with(['images', 'store'])
            ->whereHas('store', function ($q) {
                $q->where('status', 'active');
            })
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('totalStores', 'totalProducts', 'verifiedStores', 'featuredProducts'));
    }
}
