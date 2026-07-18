<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\ServicePackage;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Service::active()->with(['images', 'store', 'category', 'packages']);

        if ($request->filled('q')) {
            $keywords = array_filter(explode(' ', $request->q));
            $query->where(function ($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('name', 'LIKE', "%{$word}%"));
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
            $query->where('starting_price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('starting_price', '<=', (int) $request->max_price);
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('starting_price', 'asc'),
            'price_high' => $query->orderBy('starting_price', 'desc'),
            'popular' => $query->orderBy('views', 'desc'),
            default => $query->latest(),
        };

        $perPage = min((int) $request->get('per_page', 20), 50);
        $services = $query->paginate($perPage);

        return response()->json([
            'services' => collect($services->items())->map(fn($s) => $this->format($s)),
            'pagination' => [
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total(),
                'has_more' => $services->hasMorePages(),
            ],
        ]);
    }

    public function show($slug): JsonResponse
    {
        $service = Service::active()
            ->where('slug', $slug)
            ->with(['images', 'store', 'category', 'packages'])
            ->firstOrFail();

        $service->increment('views');

        $reviews = $service->reviews()->with('user')->latest()->get();
        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;

        $isFavorited = auth()->check()
            ? $service->follows()->where('user_id', auth()->id())->exists()
            : false;

        return response()->json([
            'service' => $this->formatDetail($service),
            'store' => [
                'id' => $service->store->id,
                'name' => $service->store->name,
                'slug' => $service->store->slug,
                'logo_url' => $service->store->logo_url,
                'banner_url' => $service->store->banner_url,
                'location' => $service->store->location,
                'whatsapp_number' => $service->store->whatsapp_number,
                'is_verified' => $service->store->is_verified,
                'badge' => $service->store->badge,
            ],
            'packages' => $service->packages->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'price' => (float) $p->price,
                'delivery_time' => $p->delivery_time,
            ]),
            'reviews' => [
                'avg_rating' => $avgRating,
                'total_reviews' => $reviews->count(),
                'items' => $reviews->map(fn($r) => [
                    'id' => $r->id,
                    'rating' => $r->rating,
                    'comment' => $r->comment,
                    'user_name' => $r->user->name,
                    'created_at' => $r->created_at,
                ]),
            ],
            'is_favorited' => $isFavorited,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'custom_category_name' => 'nullable|string|max:255',
            'starting_price' => 'required|numeric|min:0',
            'delivery_time' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive',
            'packages' => 'nullable|array',
            'packages.*.name' => 'required|string|max:255',
            'packages.*.description' => 'nullable|string',
            'packages.*.price' => 'required|numeric|min:0',
            'packages.*.delivery_time' => 'nullable|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        $categoryId = $request->category_id;
        if (!$categoryId && $request->filled('custom_category_name')) {
            $category = Category::create([
                'name' => $request->custom_category_name,
                'slug' => Str::slug($request->custom_category_name) . '-' . Str::random(4),
                'type' => 'service',
            ]);
            $categoryId = $category->id;
        } elseif (!$categoryId) {
            return response()->json(['message' => 'Category or custom category name is required.'], 422);
        }

        $service = Service::create([
            'store_id' => auth()->user()->store->id,
            'category_id' => $categoryId,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'delivery_time' => $request->delivery_time,
            'status' => $request->status ?? 'active',
            'approval_status' => 'approved',
        ]);

        if ($request->has('packages')) {
            foreach ($request->packages as $pkg) {
                ServicePackage::create([
                    'service_id' => $service->id,
                    'name' => $pkg['name'],
                    'description' => $pkg['description'] ?? null,
                    'price' => $pkg['price'],
                    'delivery_time' => $pkg['delivery_time'] ?? null,
                ]);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('services', 'r2');
                ServiceImage::create([
                    'service_id' => $service->id,
                    'path' => $path,
                    'is_main' => $i === 0,
                ]);
            }
        }

        return response()->json([
            'message' => 'Service created successfully.',
            'service' => $this->format($service->fresh()->load(['images', 'packages', 'store', 'category'])),
        ], 201);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        if ($service->store_id !== auth()->user()->store?->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|exists:categories,id',
            'starting_price' => 'sometimes|numeric|min:0',
            'delivery_time' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive',
            'packages' => 'nullable|array',
            'packages.*.id' => 'nullable|exists:service_packages,id',
            'packages.*.name' => 'required|string|max:255',
            'packages.*.description' => 'nullable|string',
            'packages.*.price' => 'required|numeric|min:0',
            'packages.*.delivery_time' => 'nullable|string|max:100',
        ]);

        $service->update($request->only([
            'name', 'description', 'category_id', 'starting_price',
            'delivery_time', 'status',
        ]));

        if ($request->has('slug') && $request->slug !== $service->slug) {
            $service->update(['slug' => Str::slug($request->slug)]);
        }

        if ($request->has('packages')) {
            $existingIds = $service->packages()->pluck('id')->toArray();
            $incomingIds = array_filter(array_column($request->packages, 'id'));

            foreach ($request->packages as $pkg) {
                if (isset($pkg['id']) && in_array($pkg['id'], $existingIds)) {
                    ServicePackage::find($pkg['id'])->update([
                        'name' => $pkg['name'],
                        'description' => $pkg['description'] ?? null,
                        'price' => $pkg['price'],
                        'delivery_time' => $pkg['delivery_time'] ?? null,
                    ]);
                } else {
                    ServicePackage::create([
                        'service_id' => $service->id,
                        'name' => $pkg['name'],
                        'description' => $pkg['description'] ?? null,
                        'price' => $pkg['price'],
                        'delivery_time' => $pkg['delivery_time'] ?? null,
                    ]);
                }
            }

            $toDelete = array_diff($existingIds, $incomingIds);
            if (!empty($toDelete)) {
                ServicePackage::whereIn('id', $toDelete)->delete();
            }
        }

        return response()->json([
            'message' => 'Service updated successfully.',
            'service' => $this->format($service->fresh()->load(['images', 'packages', 'store', 'category'])),
        ]);
    }

    public function destroy(Service $service): JsonResponse
    {
        if ($service->store_id !== auth()->user()->store?->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        foreach ($service->images as $img) {
            Storage::disk('r2')->delete($img->path);
            $img->delete();
        }

        $service->packages()->delete();
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully.',
        ]);
    }

    public function myListings(): JsonResponse
    {
        $store = auth()->user()->store;

        if (!$store) {
            return response()->json(['services' => []]);
        }

        $items = Service::where('store_id', $store->id)
            ->with(['images', 'category', 'packages'])
            ->latest()
            ->paginate(50);

        return response()->json([
            'services' => collect($items->items())->map(fn($s) => $this->format($s)),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
                'total'        => $items->total(),
            ],
        ]);
    }

    private function format($service): array
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'slug' => $service->slug,
            'starting_price' => (float) $service->starting_price,
            'delivery_time' => $service->delivery_time,
            'views' => $service->views,
            'main_image_url' => $service->main_image_url,
            'store_id' => $service->store_id,
            'store_name' => $service->store?->name,
            'store_slug' => $service->store?->slug,
            'category_id' => $service->category_id,
            'category_name' => $service->category?->name,
            'category_slug' => $service->category?->slug,
        ];
    }

    private function formatDetail($service): array
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'slug' => $service->slug,
            'description' => $service->description,
            'starting_price' => (float) $service->starting_price,
            'delivery_time' => $service->delivery_time,
            'status' => $service->status,
            'views' => $service->views,
            'store_id' => $service->store_id,
            'images' => $service->images->map(fn($i) => [
                'id' => $i->id,
                'url' => $i->url,
                'is_main' => $i->is_main,
            ]),
            'category' => $service->category ? [
                'id' => $service->category->id,
                'name' => $service->category->name,
                'slug' => $service->category->slug,
            ] : null,
            'created_at' => $service->created_at,
        ];
    }
}
