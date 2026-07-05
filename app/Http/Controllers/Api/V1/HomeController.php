<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $stats = [
            'total_stores' => Store::where('status', 'active')->count(),
            'total_products' => Product::whereHas('store', fn($q) => $q->where('status', 'active'))->count(),
            'verified_stores' => Store::where('status', 'active')->where('is_verified', true)->count(),
        ];

        $categories = Category::whereHas('products', fn($q) => $q->whereHas('store', fn($sq) => $sq->where('status', 'active')))
            ->withCount(['products' => fn($q) => $q->whereHas('store', fn($sq) => $sq->where('status', 'active'))])
            ->orderBy('name')
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'icon' => $c->icon,
                'image_url' => $c->image_url,
                'products_count' => $c->products_count,
            ]);

        $featured_products = Product::active()
            ->with(['images', 'store'])
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(fn($p) => $this->formatProduct($p));

        $trending_products = Product::active()
            ->with(['images', 'store'])
            ->orderBy('views', 'desc')
            ->take(8)
            ->get()
            ->map(fn($p) => $this->formatProduct($p));

        $latest_products = Product::active()
            ->with(['images', 'store', 'category'])
            ->latest()
            ->take(12)
            ->get()
            ->map(fn($p) => $this->formatProduct($p));

        $stores = Store::where('status', 'active')
            ->has('products')
            ->withCount('products')
            ->inRandomOrder()
            ->take(6)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
                'logo_url' => $s->logo_url,
                'banner_url' => $s->banner_url,
                'location' => $s->location,
                'is_verified' => $s->is_verified,
                'badge' => $s->badge,
                'products_count' => $s->products_count,
            ]);

        return response()->json([
            'stats' => $stats,
            'categories' => $categories,
            'featured_products' => $featured_products,
            'trending_products' => $trending_products,
            'latest_products' => $latest_products,
            'stores' => $stores,
        ]);
    }

    private function formatProduct($product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => (float) $product->price,
            'old_price' => (float) $product->old_price,
            'stock_status' => $product->stock_status,
            'is_featured' => $product->is_featured,
            'views' => $product->views,
            'main_image_url' => $product->mainImage?->url ?? $product->images->first()?->url,
            'images' => $product->images->map(fn($i) => ['id' => $i->id, 'url' => $i->url, 'is_main' => $i->is_main]),
            'store' => $product->store ? [
                'id' => $product->store->id,
                'name' => $product->store->name,
                'slug' => $product->store->slug,
                'logo_url' => $product->store->logo_url,
                'is_verified' => $product->store->is_verified,
            ] : null,
            'created_at' => $product->created_at,
        ];
    }
}
