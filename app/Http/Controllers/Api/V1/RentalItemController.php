<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RentalItem;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RentalItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = RentalItem::with(['store', 'category'])->where('status', 'published');

        if ($request->filled('q')) {
            $keywords = array_filter(explode(' ', $request->q));
            $query->where(function ($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhere('location', 'LIKE', "%{$word}%");
                }
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->filled('min_price')) {
            $query->where('rate', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('rate', '<=', (int) $request->max_price);
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('rate', 'asc'),
            'price_high' => $query->orderBy('rate', 'desc'),
            'popular' => $query->orderBy('views', 'desc'),
            default => $query->latest(),
        };

        $items = $query->paginate(20);

        return response()->json([
            'rental_items' => collect($items->items())->map(fn($r) => [
                'id' => $r->id,
                'name' => $r->name,
                'slug' => $r->slug,
                'description' => $r->description,
                'rate' => (float) $r->rate,
                'billing_unit' => $r->billing_unit,
                'deposit' => (float) $r->deposit,
                'images' => $r->images ?? [],
                'images_url' => $r->images_url,
                'main_image_url' => $r->main_image_url,
                'location' => $r->location,
                'rating' => (float) $r->rating,
                'review_count' => $r->review_count,
                'store_name' => $r->store->name,
                'store_slug' => $r->store->slug,
                'category_name' => $r->category?->name,
                'created_at' => $r->created_at,
            ]),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    public function show(RentalItem $rentalItem): JsonResponse
    {
        $rentalItem->load(['store', 'category', 'subcategory']);
        $rentalItem->increment('views');

        return response()->json([
            'rental_item' => [
                'id' => $rentalItem->id,
                'store_id' => $rentalItem->store_id,
                'store_name' => $rentalItem->store->name,
                'store_slug' => $rentalItem->store->slug,
                'name' => $rentalItem->name,
                'slug' => $rentalItem->slug,
                'description' => $rentalItem->description,
                'rate' => (float) $rentalItem->rate,
                'billing_unit' => $rentalItem->billing_unit,
                'deposit' => (float) $rentalItem->deposit,
                'images' => $rentalItem->images ?? [],
                'images_url' => $rentalItem->images_url,
                'main_image_url' => $rentalItem->main_image_url,
                'category_id' => $rentalItem->category_id,
                'category_name' => $rentalItem->category?->name,
                'subcategory_id' => $rentalItem->subcategory_id,
                'availability_calendar' => $rentalItem->availability_calendar ?? [],
                'return_conditions' => $rentalItem->return_conditions,
                'duration_rules' => $rentalItem->duration_rules,
                'condition_notes' => $rentalItem->condition_notes,
                'serial_number' => $rentalItem->serial_number,
                'location' => $rentalItem->location,
                'status' => $rentalItem->status,
                'rating' => (float) $rentalItem->rating,
                'review_count' => $rentalItem->review_count,
                'created_at' => $rentalItem->created_at,
                'updated_at' => $rentalItem->updated_at,
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'rate' => 'required|numeric|min:0',
            'billing_unit' => 'required|in:hourly,daily,weekly,monthly',
            'deposit' => 'nullable|numeric|min:0',
            'return_conditions' => 'required|string',
            'duration_rules' => 'required|string',
            'condition_notes' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'custom_category_name' => 'nullable|string|max:255',
            'subcategory_id' => 'nullable|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        $categoryId = $validated['category_id'] ?? null;
        if (!$categoryId && $request->filled('custom_category_name')) {
            $category = Category::create([
                'name' => $request->custom_category_name,
                'slug' => Str::slug($request->custom_category_name) . '-' . Str::random(4),
                'type' => 'rental',
            ]);
            $categoryId = $category->id;
        }

        $store = Store::where('user_id', auth()->id())->firstOrFail();

        $rentalItem = RentalItem::create([
            'store_id' => $store->id,
            'category_id' => $categoryId,
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'description' => $validated['description'],
            'rate' => $validated['rate'],
            'billing_unit' => $validated['billing_unit'],
            'deposit' => $validated['deposit'] ?? null,
            'return_conditions' => $validated['return_conditions'],
            'duration_rules' => $validated['duration_rules'],
            'condition_notes' => $validated['condition_notes'] ?? null,
            'serial_number' => $validated['serial_number'] ?? null,
            'location' => $validated['location'],
            'images' => $request->hasFile('images')
                ? collect($request->file('images'))->map(function ($file) {
                    $path = $file->store('rentals', 'r2');
                    if ($path) return url('/r2/' . ltrim($path, '/'));
                    $path = $file->store('rentals', 'public');
                    return $path ? Storage::disk('public')->url($path) : null;
                })->filter()->values()->toArray()
                : [],
        ]);

        return response()->json([
            'message' => 'Rental item created.',
            'rental_item' => $rentalItem->fresh(),
        ], 201);
    }

    public function update(Request $request, RentalItem $rentalItem): JsonResponse
    {
        if ($rentalItem->store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'rate' => 'required|numeric|min:0',
            'billing_unit' => 'required|in:hourly,daily,weekly,monthly',
            'deposit' => 'nullable|numeric|min:0',
            'return_conditions' => 'required|string',
            'duration_rules' => 'required|string',
            'condition_notes' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:draft,published,archived',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        if ($request->hasFile('images')) {
            $validated['images'] = collect($request->file('images'))
                ->map(function ($file) {
                    $path = $file->store('rentals', 'r2');
                    if ($path) return url('/r2/' . ltrim($path, '/'));
                    $path = $file->store('rentals', 'public');
                    return $path ? Storage::disk('public')->url($path) : null;
                })->filter()->values()->toArray();
        }

        $rentalItem->update($validated);

        $rentalItem->load(['store', 'category', 'subcategory']);

        return response()->json([
            'message' => 'Rental item updated.',
            'rental_item' => $rentalItem,
        ]);
    }

    public function destroy(RentalItem $rentalItem): JsonResponse
    {
        if ($rentalItem->store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $rentalItem->delete();

        return response()->json([
            'message' => 'Rental item deleted.',
        ]);
    }

    public function availability(RentalItem $rentalItem): JsonResponse
    {
        $calendar = $rentalItem->availability_calendar ?? [];
        $bookedDates = $rentalItem->transactions()
            ->whereIn('status', ['confirmed', 'active'])
            ->get()
            ->flatMap(fn($t) => $t->start_date->toPeriod($t->end_date)->toArray())
            ->map(fn($d) => $d->format('Y-m-d'))
            ->values();

        return response()->json([
            'availability_calendar' => $calendar,
            'booked_dates' => $bookedDates->unique()->values(),
        ]);
    }

    public function myListings(): JsonResponse
    {
        $store = Store::where('user_id', auth()->id())->first();

        if (!$store) {
            return response()->json(['rental_items' => []]);
        }

        $items = RentalItem::where('store_id', $store->id)->latest()->paginate(20);

        return response()->json([
            'rental_items' => $items->items(),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'total' => $items->total(),
            ],
        ]);
    }
}
