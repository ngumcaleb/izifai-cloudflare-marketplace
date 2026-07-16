<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Store::where('status', 'active')
            ->withCount(['products', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->with('products.images');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('verified')) {
            $query->where('is_verified', true);
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'rating':
                $query->orderByDesc('reviews_avg_rating');
                break;
            case 'products':
                $query->orderByDesc('products_count');
                break;
            default:
                $query->latest();
                break;
        }

        $perPage = min((int) $request->get('per_page', 20), 50);
        $stores = $query->paginate($perPage);

        return response()->json([
            'stores' => collect($stores->items())->map(fn($s) => [
                'id' => $s->id,
                'user_id' => $s->user_id,
                'name' => $s->name,
                'slug' => $s->slug,
                'logo_url' => $s->logo_url,
                'banner_url' => $s->banner_url,
                'location' => $s->location,
                'is_verified' => $s->is_verified,
                'badge' => $s->badge,
                'avg_rating' => $s->reviews_avg_rating ? round($s->reviews_avg_rating, 1) : 0,
                'reviews_count' => $s->reviews_count,
                'products_count' => $s->products_count,
                'description' => $s->description,
            ]),
            'pagination' => [
                'current_page' => $stores->currentPage(),
                'last_page' => $stores->lastPage(),
                'per_page' => $stores->perPage(),
                'total' => $stores->total(),
                'has_more' => $stores->hasMorePages(),
            ],
        ]);
    }

    public function show($slug): JsonResponse
    {
        $store = Store::with('user')->where('slug', $slug)->where('status', 'active')->firstOrFail();

        $reviews = $store->reviews()->with('user')->latest()->get();
        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;

        $starDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $percentage = $reviews->count() > 0 ? ($count / $reviews->count()) * 100 : 0;
            $starDistribution[$i] = ['count' => $count, 'percentage' => round($percentage, 1)];
        }

        return response()->json([
            'store' => [
                'id' => $store->id,
                'user_id' => $store->user_id,
                'name' => $store->name,
                'slug' => $store->slug,
                'description' => $store->description,
                'logo_url' => $store->logo_url,
                'banner_url' => $store->banner_url,
                'location' => $store->location,
                'whatsapp_number' => $store->whatsapp_number,
                'business_email' => $store->business_email,
                'open_hours' => $store->open_hours,
                'social_links' => $store->social_links,
                'is_verified' => $store->is_verified,
                'badge' => $store->badge,
                'created_at' => $store->created_at,
                'user' => $store->user ? ['name' => $store->user->name, 'profile_photo_url' => $store->user->profile_photo_url] : null,
            ],
            'reviews' => [
                'avg_rating' => $avgRating,
                'total_reviews' => $reviews->count(),
                'star_distribution' => $starDistribution,
                'items' => $reviews->map(fn($r) => [
                    'id' => $r->id,
                    'rating' => $r->rating,
                    'comment' => $r->comment,
                    'user_name' => $r->user->name,
                    'created_at' => $r->created_at,
                ]),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'open_hours' => 'nullable|string|max:500',
            'social_links' => 'nullable|array',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['name', 'description', 'location', 'whatsapp_number', 'business_email', 'open_hours']);
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(4);
        $data['user_id'] = auth()->id();
        $data['status'] = 'active';

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('store-logos', 'r2');
        }
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('store-banners', 'r2');
        }

        $store = Store::create($data);

        return response()->json([
            'message' => 'Store created.',
            'store' => $store->fresh(),
        ], 201);
    }

    public function update(Request $request, Store $store): JsonResponse
    {
        if ($store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'open_hours' => 'nullable|string|max:500',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'nullable|string|max:50',
            'social_links.*.url' => 'nullable|url|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['name', 'description', 'location', 'whatsapp_number', 'business_email', 'open_hours']);

        if ($request->has('social_links')) {
            $data['social_links'] = array_values(array_filter(
                $request->social_links,
                fn ($link) => !empty($link['platform']) || !empty($link['url'])
            ));
        }

        if (isset($data['name']) && $data['name'] !== $store->name) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        }

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                \Illuminate\Support\Facades\Storage::disk('r2')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('store-logos', 'r2');
        }

        if ($request->hasFile('banner')) {
            if ($store->banner) {
                \Illuminate\Support\Facades\Storage::disk('r2')->delete($store->banner);
            }
            $data['banner'] = $request->file('banner')->store('store-banners', 'r2');
        }

        $store->update($data);

        if ($request->filled('user_name') && $store->user) {
            $store->user->update(['name' => $request->user_name]);
        }

        return response()->json([
            'message' => 'Store updated.',
            'store' => $store->fresh(),
        ]);
    }

    public function services(Request $request, $slug): JsonResponse
    {
        $store = Store::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $query = Service::where('store_id', $store->id)->with(['images', 'category', 'packages']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('description', 'LIKE', "%{$q}%");
            });
        }

        $services = $query->latest()->paginate(20);

        return response()->json([
            'services' => $services->items(),
            'pagination' => [
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
                'total' => $services->total(),
            ],
        ]);
    }

    public function follow(Store $store): JsonResponse
    {
        $existing = Follow::where('user_id', auth()->id())
            ->where('followable_type', Store::class)
            ->where('followable_id', $store->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $following = false;
        } else {
            Follow::create([
                'user_id' => auth()->id(),
                'followable_type' => Store::class,
                'followable_id' => $store->id,
            ]);
            $following = true;
        }

        return response()->json(['following' => $following]);
    }

    public function featured(): JsonResponse
    {
        $stores = Store::where('status', 'active')
            ->where('is_verified', true)
            ->withCount('products')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(10)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
                'logo_url' => $s->logo_url,
                'location' => $s->location,
                'is_verified' => $s->is_verified,
                'badge' => $s->badge,
                'avg_rating' => $s->reviews_avg_rating ? round($s->reviews_avg_rating, 1) : 0,
                'products_count' => $s->products_count,
            ]);

        return response()->json(['stores' => $stores]);
    }

    public function products(Request $request, $slug): JsonResponse
    {
        $store = Store::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $query = $store->products()->with(['images', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $perPage = min((int) $request->get('per_page', 20), 50);
        $products = $query->paginate($perPage);

        return response()->json([
            'products' => collect($products->items())->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => (float) $p->price,
                'old_price' => (float) $p->old_price,
                'stock_status' => $p->stock_status,
                'views' => $p->views,
                'main_image_url' => $p->images->first()?->url,
                'category_name' => $p->category?->name,
                'category_slug' => $p->category?->slug,
            ]),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'has_more' => $products->hasMorePages(),
            ],
        ]);
    }
}
