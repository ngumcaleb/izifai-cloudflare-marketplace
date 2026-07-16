<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::active()->with(['images', 'store', 'category', 'specifications']);

        if ($request->filled('q')) {
            $keywords = array_filter(explode(' ', $request->q));
            $query->where(function ($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('name', 'LIKE', "%{$word}%")
                            ->orWhere('location', 'LIKE', "%{$word}%"));
                }
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('store')) {
            $query->whereHas('store', fn($q) => $q->where('slug', $request->store));
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
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $perPage = min((int) $request->get('per_page', 20), 50);
        $products = $query->paginate($perPage);

        return response()->json([
            'products' => collect($products->items())->map(fn($p) => $this->format($p)),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'has_more' => $products->hasMorePages(),
            ],
        ]);
    }

    public function show($slug): JsonResponse
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with(['images', 'store', 'category', 'specifications', 'attributes.values'])
            ->firstOrFail();

        $product->increment('views');

        $store = $product->store;
        $reviews = $product->reviews()->with('user')->latest()->get();
        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;

        $storeProducts = $store->products()
            ->where('id', '!=', $product->id)
            ->with('images')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn($p) => $this->format($p));

        $isFavorited = false;
        $token = request()->bearerToken();
        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken) {
                $user = $accessToken->tokenable;
                $isFavorited = $product->savedUsers()->where('user_id', $user->id)->exists();
            }
        }

        return response()->json([
            'product' => $this->formatDetail($product),
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
                'avg_rating' => $avgRating,
                'total_reviews' => $reviews->count(),
                'total_products' => $store->products()->count(),
            ],
            'reviews' => $reviews->map(fn($r) => [
                'id' => $r->id,
                'rating' => $r->rating,
                'comment' => $r->comment,
                'user_id' => $r->user_id,
                'user_name' => $r->user->name,
                'created_at' => $r->created_at,
            ]),
            'store_products' => $storeProducts,
            'is_favorited' => $isFavorited,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $store = auth()->user()->store;
        if (!$store) {
            return response()->json(['message' => 'Store required.'], 400);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'custom_category_name' => 'nullable|string|max:255',
            'stock_status' => 'nullable|in:in_stock,out_of_stock,pre_order',
            'brand' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255',
            'inventory' => 'nullable|integer|min:0',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'required|string',
            'specifications.*.value' => 'required|string',
        ]);

        $categoryId = $validated['category_id'] ?? null;
        if (!$categoryId && $request->filled('custom_category_name')) {
            $category = Category::create([
                'name' => $request->custom_category_name,
                'slug' => Str::slug($request->custom_category_name) . '-' . Str::random(4),
                'type' => 'product',
            ]);
            $categoryId = $category->id;
        } elseif (!$categoryId) {
            return response()->json(['message' => 'Category or custom category name is required.'], 422);
        }

        $product = Product::create([
            'store_id' => $store->id,
            'category_id' => $categoryId,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'old_price' => $validated['old_price'] ?? null,
            'stock_status' => $validated['stock_status'] ?? 'in_stock',
            'brand' => $validated['brand'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'inventory' => $validated['inventory'] ?? 0,
            'colors' => $validated['colors'] ?? [],
            'sizes' => $validated['sizes'] ?? [],
            'approval_status' => 'approved',
        ]);

        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'key' => $spec['key'],
                    'value' => $spec['value'],
                ]);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'r2');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_main' => $i === 0,
                ]);
            }
        }

        return response()->json([
            'message' => 'Product created.',
            'product' => $product->fresh()->load(['images', 'specifications', 'category']),
        ], 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        if ($product->store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'name'             => 'sometimes|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'sometimes|numeric|min:0',
            'discount_price'   => 'nullable|numeric|min:0',
            'old_price'        => 'nullable|numeric|min:0',
            'category_id'      => 'sometimes|exists:categories,id',
            'stock_status'     => 'nullable|in:in_stock,out_of_stock,pre_order,on_request',
            'brand'            => 'nullable|string|max:255',
            'sku'              => 'nullable|string|max:255',
            'inventory'        => 'nullable|integer|min:0',
            'images'           => 'nullable|array',
            'images.*'         => 'image|max:5120',
            'existing_images'  => 'nullable|array',
            'specifications'   => 'nullable|array',
        ]);

        $fields = $request->only(['name', 'description', 'price', 'category_id', 'stock_status', 'brand', 'sku', 'inventory']);

        // Map discount_price → old_price (mobile sends discount_price; DB column is old_price)
        if ($request->filled('discount_price')) {
            $fields['old_price'] = $request->input('discount_price');
        } elseif ($request->has('old_price')) {
            $fields['old_price'] = $request->input('old_price') ?: null;
        } elseif ($request->has('discount_price') && !$request->filled('discount_price')) {
            $fields['old_price'] = null; // explicitly cleared
        }

        if (isset($fields['name']) && $fields['name'] !== $product->name) {
            $fields['slug'] = Str::slug($fields['name']) . '-' . Str::random(6);
        }

        $product->update($fields);

        // ── Images: keep existing, delete removed, upload new ────────────────
        $keepUrls = (array) $request->input('existing_images', []);

        foreach ($product->images as $img) {
            if (!empty($keepUrls) && !in_array($img->url, $keepUrls)) {
                Storage::disk('r2')->delete($img->path);
                $img->delete();
            }
        }

        if ($request->hasFile('images')) {
            $product->refresh();
            $isFirst = $product->images()->count() === 0;
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'r2');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path,
                    'is_main'    => $isFirst && $i === 0,
                ]);
            }
        }

        // ── Specifications: replace all ──────────────────────────────────────
        if ($request->has('specifications')) {
            $product->specifications()->delete();
            foreach ((array) $request->input('specifications', []) as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'key'        => $spec['key'],
                        'value'      => $spec['value'],
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Product updated.',
            'product' => $product->fresh()->load(['images', 'specifications', 'category']),
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        foreach ($product->images as $img) {
            Storage::disk('r2')->delete($img->path);
            $img->delete();
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted.']);
    }

    public function myListings(): JsonResponse
    {
        $store = auth()->user()->store;

        if (!$store) {
            return response()->json(['products' => []]);
        }

        $items = Product::where('store_id', $store->id)
            ->with(['images', 'category', 'specifications'])
            ->latest()
            ->paginate(50);

        return response()->json([
            'products' => collect($items->items())->map(fn($p) => $this->formatDetail($p)),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
                'total'        => $items->total(),
            ],
        ]);
    }



    public function featured(): JsonResponse
    {
        $products = Product::active()
            ->where('is_featured', true)
            ->where(function ($q) {
                $q->whereNull('featured_until')->orWhere('featured_until', '>=', now());
            })
            ->with(['images', 'store', 'category'])
            ->inRandomOrder()
            ->take(10)
            ->get()
            ->map(fn($p) => $this->format($p));

        return response()->json(['products' => $products]);
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $q = $request->query('q');
        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::active()->with('images', 'category')
            ->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('description', 'LIKE', "%{$q}%");
            })
            ->latest()
            ->take(6)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => (float) $p->price,
                'old_price' => (float) $p->old_price,
                'image_url' => $p->images->first()?->url,
                'category' => $p->category?->name,
            ]);

        return response()->json($products);
    }

    private function format($product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => (float) $product->price,
            'old_price' => (float) $product->old_price,
            'inventory' => (int) $product->inventory,
            'stock_status' => $product->stock_status,
            'is_featured' => $product->is_featured,
            'views' => $product->views,
            'main_image_url' => $product->mainImage?->url ?? $product->images->first()?->url,
            'store_id' => $product->store_id,
            'store_name' => $product->store?->name,
            'store_slug' => $product->store?->slug,
            'category_id' => $product->category_id,
            'category_name' => $product->category?->name,
            'category_slug' => $product->category?->slug,
            'brand' => $product->brand,
            'sku' => $product->sku,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];
    }

    private function formatDetail($product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => (float) $product->price,
            'old_price' => (float) $product->old_price,
            'inventory' => (int) $product->inventory,
            'stock_status' => $product->stock_status,
            'is_featured' => $product->is_featured,
            'views' => $product->views,
            'colors' => $product->colors,
            'sizes' => $product->sizes,
            'rating' => (float) $product->rating,
            'review_count' => (int) $product->review_count,
            'images' => $product->images->map(fn($i) => [
                'id' => $i->id,
                'url' => $i->url,
                'is_main' => $i->is_main,
            ]),
            'specifications' => $product->specifications->map(fn($s) => [
                'key' => $s->key,
                'value' => $s->value,
            ]),
            'attributes' => $product->attributes->map(fn($a) => [
                'name' => $a->name,
                'values' => $a->values->pluck('value'),
            ]),
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
            ] : null,
            'created_at' => $product->created_at,
        ];
    }
}
