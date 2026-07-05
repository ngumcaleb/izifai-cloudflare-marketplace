<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q');
        $type = $request->query('type', 'products');
        $city = $request->query('city');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');

        if ($type === 'stores') {
            $query = Store::where('status', 'active');

            if ($q) {
                $keywords = array_filter(explode(' ', $q));
                $query->where(function ($sub) use ($keywords) {
                    foreach ($keywords as $word) {
                        $sub->orWhere('name', 'LIKE', "%{$word}%")
                            ->orWhere('description', 'LIKE', "%{$word}%")
                            ->orWhere('location', 'LIKE', "%{$word}%");
                    }
                });
            }

            if ($city) {
                $query->where('location', 'LIKE', "%{$city}%");
            }

            $stores = $query->latest()->paginate(20);

            return response()->json([
                'stores' => collect($stores->items())->map(fn($s) => [
                    'id' => $s->id,
                    'name' => $s->name,
                    'slug' => $s->slug,
                    'logo_url' => $s->logo_url,
                    'location' => $s->location,
                    'is_verified' => $s->is_verified,
                    'badge' => $s->badge,
                    'description' => $s->description,
                ]),
                'pagination' => [
                    'current_page' => $stores->currentPage(),
                    'last_page' => $stores->lastPage(),
                    'total' => $stores->total(),
                ],
            ]);
        }

        $query = Product::active()->with(['images', 'store', 'category']);

        if ($q) {
            $keywords = array_filter(explode(' ', $q));
            $query->where(function ($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('specifications', fn($s) => $s->where('value', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('location', 'LIKE', "%{$word}%"));
                }
            });
        }

        if ($city) {
            $query->whereHas('store', fn($s) => $s->where('location', 'LIKE', "%{$city}%"));
        }
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        $products = $query->latest()->paginate(20);

        return response()->json([
            'products' => collect($products->items())->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => (float) $p->price,
                'old_price' => (float) $p->old_price,
                'main_image_url' => $p->images->first()?->url,
                'store_name' => $p->store?->name,
                'store_slug' => $p->store?->slug,
                'category_name' => $p->category?->name,
            ]),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $q = $request->query('q');
        if (!$q || strlen($q) < 2) {
            return response()->json(['products' => [], 'stores' => [], 'categories' => []]);
        }

        $keywords = array_filter(explode(' ', $q));

        $categories = Category::whereHas('products', fn($q) => $q->active());
        foreach ($keywords as $word) {
            $categories->where('name', 'LIKE', "%{$word}%");
        }
        $categoryResults = $categories->take(3)->get()->map(fn($c) => [
            'id' => $c->id, 'name' => $c->name, 'slug' => $c->slug, 'type' => 'category',
        ]);

        $stores = Store::where('status', 'active');
        foreach ($keywords as $word) {
            $stores->where(function ($q) use ($word) {
                $q->where('name', 'LIKE', "%{$word}%")->orWhere('location', 'LIKE', "%{$word}%");
            });
        }
        $storeResults = $stores->take(3)->get()->map(fn($s) => [
            'id' => $s->id, 'name' => $s->name, 'slug' => $s->slug, 'type' => 'store',
            'logo_url' => $s->logo_url, 'is_verified' => $s->is_verified,
        ]);

        $products = Product::active()->with('category');
        $products->where(function ($sub) use ($keywords) {
            foreach ($keywords as $word) {
                $sub->orWhere('name', 'LIKE', "%{$word}%")
                    ->orWhere('description', 'LIKE', "%{$word}%");
            }
        });
        $productResults = $products->orderByDesc('views')->take(6)->get()->map(fn($p) => [
            'id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'type' => 'product',
            'price' => (float) $p->price, 'category' => $p->category?->name,
        ]);

        return response()->json([
            'products' => $productResults,
            'stores' => $storeResults,
            'categories' => $categoryResults,
        ]);
    }

    public function trending(): JsonResponse
    {
        $categories = Category::whereHas('products', fn($q) => $q->active())
            ->withCount(['products' => fn($q) => $q->active()])
            ->orderByDesc('products_count')
            ->take(8)
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'products_count' => $c->products_count,
            ]);

        return response()->json(['trending_categories' => $categories]);
    }
}
