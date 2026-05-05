<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with(['images', 'store', 'savedUsers'])->latest()->paginate(24);
        $title = "New Arrivals";
        $description = "Browse the latest wholesale and retail products from verified sellers in Cameroon.";
        
        return view('products.index', compact('products', 'title', 'description'));
    }

    public function localSourcing(Request $request)
    {
        $query = \App\Models\Product::with(['images', 'store', 'savedUsers']);

        if ($request->city) {
            $query->whereHas('store', function($q) use ($request) {
                $q->where('location', $request->city);
            });
        }

        $products = $query->latest()->paginate(24);
        
        $cities = \App\Models\Store::whereNotNull('location')->distinct()->pluck('location');
        
        $title = $request->city ? "Local Sourcing in " . $request->city : "Local Sourcing";
        $description = "Connect with suppliers in your immediate area for faster logistics and communication.";

        return view('products.index', compact('products', 'title', 'description', 'cities'));
    }
    public function search(Request $request)
    {
        $q = $request->query('q');
        $type = $request->query('type', 'products');
        $city = $request->query('city');

        if ($type === 'sellers') {
            $query = \App\Models\Store::query();
            
            if ($q) {
                $keywords = array_filter(explode(' ', $q));
                $query->where(function($sub) use ($keywords) {
                    foreach ($keywords as $word) {
                        $sub->orWhere('name', 'LIKE', "%{$word}%")
                            ->orWhere('description', 'LIKE', "%{$word}%");
                    }
                });
            }

            if ($city) {
                $query->where('location', $city);
            }

            $stores = $query->latest()->paginate(24);
            
            return view('stores.index', [
                'stores' => $stores,
                'title' => ($q ? "Search: " . $q : "Sellers") . ($city ? " in " . $city : ""),
                'description' => "Found " . $stores->total() . " sellers matching your criteria."
            ]);
        }

        $query = \App\Models\Product::with(['images', 'store', 'savedUsers']);

        if ($q) {
            $keywords = array_filter(explode(' ', $q));
            $query->where(function($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', function($catQuery) use ($word) {
                            $catQuery->where('name', 'LIKE', "%{$word}%");
                        })
                        ->orWhereHas('specifications', function($specQuery) use ($word) {
                            $specQuery->where('value', 'LIKE', "%{$word}%");
                        })
                        ->orWhereHas('store', function($storeQuery) use ($word) {
                            $storeQuery->where('location', 'LIKE', "%{$word}%");
                        });
                }
            });
        }

        if ($city) {
            $query->whereHas('store', function($sub) use ($city) {
                $sub->where('location', $city);
            });
        }

        $products = $query->latest()->paginate(24);

        $title = ($q ? "Search: " . $q : "Products") . ($city ? " in " . $city : "");
        $description = "Found " . $products->total() . " products matching your criteria.";

        return view('products.index', compact('products', 'title', 'description'));
    }

    public function show($slug)
    {
        $product = \App\Models\Product::where('slug', $slug)->with(['images', 'store', 'specifications', 'category'])->firstOrFail();
        $product->increment('views');
        return view('products.show', compact('product'));
    }

    public function autocomplete(Request $request)
    {
        $q = $request->query('q');
        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $keywords = array_filter(explode(' ', $q));
        
        // 1. Search Categories (Max 2)
        $categoriesQuery = \App\Models\Category::query();
        foreach ($keywords as $word) {
            $categoriesQuery->where('name', 'LIKE', "%{$word}%");
        }
        $categories = $categoriesQuery->take(2)->get()->map(function($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'type' => 'category',
                'icon' => '<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>',
                'url' => route('categories.show', $cat->slug)
            ];
        });

        // 2. Search Stores (Max 2)
        $storesQuery = \App\Models\Store::where('is_verified', true);
        foreach ($keywords as $word) {
            $storesQuery->where('name', 'LIKE', "%{$word}%");
        }
        $stores = $storesQuery->take(2)->get()->map(function($store) {
            return [
                'id' => $store->id,
                'name' => $store->name,
                'type' => 'store',
                'icon' => '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
                'url' => route('stores.show', $store->slug)
            ];
        });

        // 3. Search Products (Max 6)
        $productsQuery = \App\Models\Product::with(['category']);
        $productsQuery->where(function($sub) use ($keywords) {
            foreach ($keywords as $word) {
                $sub->orWhere('name', 'LIKE', "%{$word}%")
                    ->orWhere('description', 'LIKE', "%{$word}%")
                    ->orWhereHas('category', function($cat) use ($word) {
                        $cat->where('name', 'LIKE', "%{$word}%");
                    })
                    ->orWhereHas('specifications', function($spec) use ($word) {
                        $spec->where('value', 'LIKE', "%{$word}%");
                    })
                    ->orWhereHas('store', function($storeQuery) use ($word) {
                        $storeQuery->where('location', 'LIKE', "%{$word}%");
                    });
            }
        });
        
        $products = $productsQuery->orderByDesc('views')->take(6)->get()->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'type' => 'product',
                'category' => $product->category->name ?? '',
                'icon' => '<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>',
                'price' => number_format($product->price) . ' XAF',
                'url' => route('products.show', $product->slug)
            ];
        });

        $results = collect()->concat($categories)->concat($stores)->concat($products);

        return response()->json($results);
    }
}
