<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $stores = Store::where('status', 'active')->with('products')->inRandomOrder()->take(8)->get();

        $stats = [
            'stores' => Store::where('status', 'active')->count(),
            'products' => Product::active()->count(),
            'categories' => Category::count(),
        ];

        return view('home', compact('categories', 'stores', 'stats'));
    }
}
