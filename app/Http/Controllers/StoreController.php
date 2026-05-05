<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::withCount('products')->with('products.images')->latest()->paginate(16);
        return view('stores.index', compact('stores'));
    }
    public function show($slug)
    {
        $store = Store::where('slug', $slug)->firstOrFail();
        $products = $store->products()->with(['images'])->latest()->paginate(12);

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

        return view('stores.show', compact('store', 'products', 'categories', 'reviews', 'starDistribution'));
    }
}
