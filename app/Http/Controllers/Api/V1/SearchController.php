<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Service;
use App\Models\RentalItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q');
        $type = $request->query('type', 'products');
        $city = $request->query('city');
        $minPrice = is_numeric($request->query('min_price')) ? (float) $request->query('min_price') : null;
        $maxPrice = is_numeric($request->query('max_price')) ? (float) $request->query('max_price') : null;
        $category = $request->query('category');
        $minRating = is_numeric($request->query('min_rating')) ? (float) $request->query('min_rating') : null;
        $page = (int) $request->query('page', 1);

        if ($type === 'stores') {
            return $this->searchStores($q, $city, $page);
        }

        if ($type === 'services') {
            return $this->searchServices($q, $city, $minPrice, $maxPrice, $category, $minRating, $page);
        }

        if ($type === 'rentals') {
            return $this->searchRentals($q, $city, $minPrice, $maxPrice, $category, $minRating, $page);
        }

        if ($type === 'all') {
            return $this->searchAll($q, $city, $minPrice, $maxPrice, $category, $minRating, $page);
        }

        return $this->searchProducts($q, $city, $minPrice, $maxPrice, $category, $minRating, $page);
    }

    private function searchProducts($q, $city, $minPrice, $maxPrice, $category, $minRating, $page): JsonResponse
    {
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
        if ($category) {
            $query->whereHas('category', fn($c) => $c->where('slug', $category));
        }
        if ($minRating) {
            $query->where('rating', '>=', $minRating);
        }

        $results = $query->latest()->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'type' => 'products',
            'items' => collect($results->items())->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => (float) $p->price,
                'old_price' => (float) $p->old_price,
                'main_image_url' => $p->images->first()?->url,
                'store_name' => $p->store?->name,
                'store_slug' => $p->store?->slug,
                'store_location' => $p->store?->location,
                'category_name' => $p->category?->name,
                'rating' => $p->rating,
                'views' => $p->views,
            ]),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'total' => $results->total(),
            ],
        ]);
    }

    private function searchStores($q, $city, $page): JsonResponse
    {
        $query = Store::where('status', 'active')->withCount('products');

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

        $results = $query->latest()->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'type' => 'stores',
            'items' => collect($results->items())->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
                'logo_url' => $s->logo_url,
                'banner_url' => $s->banner_url,
                'location' => $s->location,
                'is_verified' => $s->is_verified,
                'badge' => $s->badge,
                'description' => $s->description,
                'products_count' => $s->products_count,
                'rating' => $s->rating,
            ]),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'total' => $results->total(),
            ],
        ]);
    }

    private function searchServices($q, $city, $minPrice, $maxPrice, $category, $minRating, $page): JsonResponse
    {
        $query = Service::with(['category', 'store']);

        if ($q) {
            $keywords = array_filter(explode(' ', $q));
            $query->where(function ($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('location', 'LIKE', "%{$word}%"));
                }
            });
        }

        if ($city) {
            $query->whereHas('store', fn($s) => $s->where('location', 'LIKE', "%{$city}%"));
        }
        if ($minPrice) {
            $query->where('starting_price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('starting_price', '<=', $maxPrice);
        }
        if ($category) {
            $query->whereHas('category', fn($c) => $c->where('slug', $category));
        }
        if ($minRating) {
            $query->where('rating', '>=', $minRating);
        }

        $results = $query->latest()->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'type' => 'services',
            'items' => collect($results->items())->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
                'starting_price' => (float) $s->starting_price,
                'main_image_url' => $s->main_image_url,
                'store_name' => $s->store?->name,
                'store_slug' => $s->store?->slug,
                'store_location' => $s->store?->location,
                'category_name' => $s->category?->name,
                'rating' => $s->rating,
                'delivery_time' => $s->delivery_time,
                'views' => $s->views,
            ]),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'total' => $results->total(),
            ],
        ]);
    }

    private function searchRentals($q, $city, $minPrice, $maxPrice, $category, $minRating, $page): JsonResponse
    {
        $query = RentalItem::with(['category', 'store']);

        if ($q) {
            $keywords = array_filter(explode(' ', $q));
            $query->where(function ($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhere('location', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('location', 'LIKE', "%{$word}%"));
                }
            });
        }

        if ($city) {
            $query->where(function ($q) use ($city) {
                $q->where('location', 'LIKE', "%{$city}%")
                    ->orWhereHas('store', fn($s) => $s->where('location', 'LIKE', "%{$city}%"));
            });
        }
        if ($minPrice) {
            $query->where('rate', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('rate', '<=', $maxPrice);
        }
        if ($category) {
            $query->whereHas('category', fn($c) => $c->where('slug', $category));
        }
        if ($minRating) {
            $query->where('rating', '>=', $minRating);
        }

        $results = $query->latest()->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'type' => 'rentals',
            'items' => collect($results->items())->map(fn($r) => [
                'id' => $r->id,
                'name' => $r->name,
                'slug' => $r->slug,
                'rate' => (float) $r->rate,
                'billing_unit' => $r->billing_unit,
                'deposit' => (float) $r->deposit,
                'location' => $r->location,
                'main_image_url' => $r->main_image_url,
                'store_name' => $r->store?->name,
                'store_slug' => $r->store?->slug,
                'store_location' => $r->store?->location,
                'category_name' => $r->category?->name,
                'rating' => $r->rating,
                'views' => $r->views,
            ]),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'total' => $results->total(),
            ],
        ]);
    }

    private function searchAll($q, $city, $minPrice, $maxPrice, $category, $minRating, $page): JsonResponse
    {
        $products = $this->searchProducts($q, $city, $minPrice, $maxPrice, $category, $minRating, $page);
        $stores = $this->searchStores($q, $city, $page);
        $services = $this->searchServices($q, $city, $minPrice, $maxPrice, $category, $minRating, $page);
        $rentals = $this->searchRentals($q, $city, $minPrice, $maxPrice, $category, $minRating, $page);

        $productsData = json_decode($products->getContent(), true);
        $storesData = json_decode($stores->getContent(), true);
        $servicesData = json_decode($services->getContent(), true);
        $rentalsData = json_decode($rentals->getContent(), true);

        return response()->json([
            'products' => $productsData['items'] ?? [],
            'stores' => $storesData['items'] ?? [],
            'services' => $servicesData['items'] ?? [],
            'rentals' => $rentalsData['items'] ?? [],
        ]);
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $q = $request->query('q');
        if (!$q || strlen($q) < 2) {
            return response()->json(['products' => [], 'stores' => [], 'categories' => [], 'locations' => []]);
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

        $locationResults = Store::where('status', 'active')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->where('location', 'LIKE', "%{$q}%")
            ->selectRaw("
                LOWER(TRIM(SUBSTRING_INDEX(location, ',', 1))) as normalized_city,
                MIN(location) as location,
                COUNT(*) as store_count
            ")
            ->groupBy('normalized_city')
            ->orderByDesc('store_count')
            ->take(3)
            ->get()
            ->map(fn($l) => [
                'name' => $l->location,
                'store_count' => $l->store_count,
                'type' => 'location',
            ]);

        return response()->json([
            'products' => $productResults,
            'stores' => $storeResults,
            'categories' => $categoryResults,
            'locations' => $locationResults,
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
