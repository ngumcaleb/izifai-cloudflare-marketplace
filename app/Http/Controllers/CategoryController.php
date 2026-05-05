<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->has('products')->whereNull('parent_id')->get();
        $randomProductImages = \App\Models\ProductImage::inRandomOrder()->limit(5)->get();
        return view('categories.index', compact('categories', 'randomProductImages'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->with(['images', 'store', 'savedUsers'])->latest()->paginate(24);
        $categories = Category::withCount('products')->has('products')->get();
        $randomProductImages = \App\Models\ProductImage::whereHas('product', function($q) use ($category) {
            $q->where('category_id', $category->id);
        })->inRandomOrder()->limit(5)->get();

        return view('categories.show', compact('category', 'products', 'categories', 'randomProductImages'));
    }
}
