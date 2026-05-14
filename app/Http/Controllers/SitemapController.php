<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $stores = Store::where('status', 'active')->select('slug', 'updated_at')->get();
        $products = Product::active()->select('slug', 'updated_at')->get();
        $categories = Category::select('slug', 'updated_at')->get();

        return response()->view('sitemap', compact('stores', 'products', 'categories'))->header('Content-Type', 'text/xml');
    }
}
