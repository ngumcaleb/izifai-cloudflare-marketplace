<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\RentalItem;
use App\Models\Store;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $totalStores = Store::where('status', 'active')->count();
        $totalProducts = Product::whereHas('store', fn($q) => $q->where('status', 'active'))->count();
        $verifiedStores = Store::where('status', 'active')->where('is_verified', true)->count();
        $totalServices = Service::active()->count();

        $stats = [
            'total_stores' => $totalStores,
            'total_products' => $totalProducts,
            'verified_stores' => $verifiedStores,
            'total_services' => $totalServices,
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
            ->map(fn($s) => $this->formatStore($s));

        $topRatedStores = Store::where('status', 'active')
            ->has('products')
            ->where('rating', '>', 0)
            ->withCount('products')
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get()
            ->map(fn($s) => $this->formatStore($s));

        $topRatedProducts = Product::active()
            ->with(['images', 'store'])
            ->where('rating', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get()
            ->map(fn($p) => $this->formatProduct($p));

        $topRatedServices = Service::active()
            ->with(['store'])
            ->where('rating', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get()
            ->map(fn($s) => $this->formatService($s));

        $topStores = Store::where('status', 'active')
            ->has('products')
            ->withCount('products')
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(fn($s) => $this->formatStore($s));

        $services = Service::active()
            ->with(['store', 'category'])
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(fn($s) => $this->formatService($s));

        $rentals = RentalItem::where('status', 'published')
            ->with(['store', 'category'])
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(fn($r) => $this->formatRental($r));

        $trending_rentals = RentalItem::where('status', 'published')
            ->with(['store', 'category'])
            ->orderBy('views', 'desc')
            ->take(6)
            ->get()
            ->map(fn($r) => $this->formatRental($r));

        return response()->json([
            'stats' => $stats,
            'categories' => $categories,
            'featured_products' => $featured_products,
            'trending_products' => $trending_products,
            'latest_products' => $latest_products,
            'stores' => $stores,
            'top_rated_stores' => $topRatedStores,
            'top_rated_products' => $topRatedProducts,
            'top_rated_services' => $topRatedServices,
            'top_stores' => $topStores,
            'services' => $services,
            'rentals' => $rentals,
            'trending_rentals' => $trending_rentals,
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
            'rating' => (float) $product->rating,
            'images' => $product->images->map(fn($i) => ['id' => $i->id, 'url' => $i->url, 'is_main' => $i->is_main]),
            'main_image_url' => $product->mainImage?->url ?? $product->images->first()?->url,
            'store' => $product->store ? [
                'id' => $product->store->id,
                'name' => $product->store->name,
                'slug' => $product->store->slug,
                'logo_url' => $product->store->logo_url,
                'is_verified' => $product->store->is_verified,
            ] : null,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
            ] : null,
            'created_at' => $product->created_at,
        ];
    }

    private function formatStore($store): array
    {
        return [
            'id' => $store->id,
            'name' => $store->name,
            'slug' => $store->slug,
            'logo_url' => $store->logo_url,
            'banner_url' => $store->banner_url,
            'location' => $store->location,
            'is_verified' => $store->is_verified,
            'badge' => $store->badge,
            'rating' => (float) $store->rating,
            'products_count' => $store->products_count ?? $store->products()->count(),
        ];
    }

    private function formatService($service): array
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'slug' => $service->slug,
            'starting_price' => (float) $service->starting_price,
            'delivery_time' => $service->delivery_time,
            'views' => $service->views,
            'rating' => (float) $service->rating,
            'main_image_url' => $service->main_image_url,
            'store' => $service->store ? [
                'id' => $service->store->id,
                'name' => $service->store->name,
                'slug' => $service->store->slug,
                'logo_url' => $service->store->logo_url,
                'is_verified' => $service->store->is_verified,
            ] : null,
            'category' => $service->category ? [
                'id' => $service->category->id,
                'name' => $service->category->name,
                'slug' => $service->category->slug,
            ] : null,
        ];
    }

    private function formatRental($rental): array
    {
        return [
            'id' => $rental->id,
            'name' => $rental->name,
            'slug' => $rental->slug,
            'rate' => (float) $rental->rate,
            'billing_unit' => $rental->billing_unit,
            'deposit' => (float) $rental->deposit,
            'location' => $rental->location,
            'views' => $rental->views,
            'rating' => (float) $rental->rating,
            'main_image_url' => $rental->main_image_url,
            'store' => $rental->store ? [
                'id' => $rental->store->id,
                'name' => $rental->store->name,
                'slug' => $rental->store->slug,
                'logo_url' => $rental->store->logo_url,
                'is_verified' => $rental->store->is_verified,
            ] : null,
            'category' => $rental->category ? [
                'id' => $rental->category->id,
                'name' => $rental->category->name,
                'slug' => $rental->category->slug,
            ] : null,
        ];
    }
}
