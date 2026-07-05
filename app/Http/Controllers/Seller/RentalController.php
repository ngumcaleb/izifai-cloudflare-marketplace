<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\RentalItem;
use App\Models\Category;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $store = auth()->user()->store;

        $query = $store->rentalItems()->with(['category']);

        if ($request->filled('collection')) {
            $query->where('store_category_id', $request->collection);
        }

        $rentals = $query->latest()->get();
        $storeCategories = $store->storeCategories()->where('type', 'rental')->withCount('rentalItems')->whereNull('parent_id')->orderBy('name')->get();

        $currentCollection = null;
        if ($request->filled('collection')) {
            $currentCollection = $storeCategories->firstWhere('id', $request->collection)
                ?? $store->storeCategories()->find($request->collection);
        }

        return view('seller.rentals.index', compact('rentals', 'storeCategories', 'currentCollection'));
    }

    public function create(Request $request)
    {
        $store = auth()->user()->store;
        $categories = Category::where('type', 'rental')->orWhereDoesntHave('rentalItems')->get();
        $storeCategories = $store ? $store->storeCategories()->where('type', 'rental')->with('children')->whereNull('parent_id')->orderBy('name')->get() : collect();

        $selectedCategory = null;
        if ($request->filled('collection')) {
            $selectedCategory = $store->storeCategories()->where('type', 'rental')->find($request->collection);
        }

        return view('seller.rentals.create', compact('categories', 'storeCategories', 'selectedCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'store_category_id' => 'nullable|exists:store_categories,id',
            'store_category_name' => 'nullable|string|max:255',
            'rate' => 'required|numeric|min:0',
            'billing_unit' => 'required|in:hourly,daily,weekly,monthly',
            'deposit' => 'nullable|numeric|min:0',
            'return_conditions' => 'nullable|string',
            'duration_rules' => 'nullable|string',
            'condition_notes' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'nullable|in:published,draft,archived',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('rentals', 'r2');
                $images[] = $path;
            }
        }

        $store = auth()->user()->store;
        $storeCategoryId = $this->resolveStoreCategory($store, $request->store_category_id, $request->store_category_name);

        $rental = RentalItem::create([
            'store_id' => $store->id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'store_category_id' => $storeCategoryId,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'description' => $request->description,
            'rate' => $request->rate,
            'billing_unit' => $request->billing_unit,
            'deposit' => $request->deposit,
            'images' => $images,
            'return_conditions' => $request->return_conditions,
            'duration_rules' => $request->duration_rules,
            'condition_notes' => $request->condition_notes,
            'serial_number' => $request->serial_number,
            'location' => $request->location,
            'status' => $request->status ?? 'published',
        ]);

        return redirect()->route('seller.rentals.index')
            ->with('success', 'Rental item created successfully.');
    }

    public function edit($id)
    {
        $store = auth()->user()->store;
        $rental = $store->rentalItems()
            ->with(['category', 'subcategory'])
            ->findOrFail($id);

        $categories = Category::where('type', 'rental')->orWhereDoesntHave('rentalItems')->get();
        $storeCategories = $store ? $store->storeCategories()->where('type', 'rental')->with('children')->whereNull('parent_id')->orderBy('name')->get() : collect();

        return view('seller.rentals.edit', compact('rental', 'categories', 'storeCategories'));
    }

    public function update(Request $request, $id)
    {
        $rental = auth()->user()->store->rentalItems()->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'store_category_id' => 'nullable|exists:store_categories,id',
            'store_category_name' => 'nullable|string|max:255',
            'rate' => 'sometimes|numeric|min:0',
            'billing_unit' => 'nullable|in:hourly,daily,weekly,monthly',
            'deposit' => 'nullable|numeric|min:0',
            'return_conditions' => 'nullable|string',
            'duration_rules' => 'nullable|string',
            'condition_notes' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'sometimes|string|max:255',
            'status' => 'nullable|in:published,draft,archived',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        $store = auth()->user()->store;
        $storeCategoryId = $this->resolveStoreCategory($store, $request->store_category_id, $request->store_category_name);

        $data = $request->only([
            'name', 'description', 'category_id', 'subcategory_id',
            'rate', 'billing_unit', 'deposit',
            'return_conditions', 'duration_rules', 'condition_notes',
            'serial_number', 'location', 'status',
        ]);
        $data['store_category_id'] = $storeCategoryId;

        if ($request->hasFile('images')) {
            $data['images'] = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('rentals', 'r2');
                $data['images'][] = $path;
            }
        }

        $rental->update($data);

        return redirect()->route('seller.rentals.index')
            ->with('success', 'Rental item updated successfully.');
    }

    public function destroy($id)
    {
        $rental = auth()->user()->store->rentalItems()->findOrFail($id);

        if ($rental->images) {
            foreach ($rental->images as $path) {
                Storage::disk('r2')->delete($path);
            }
        }

        $rental->delete();

        return redirect()->route('seller.rentals.index')
            ->with('success', 'Rental item deleted successfully.');
    }

    private function resolveStoreCategory($store, $storeCategoryId, $storeCategoryName): ?int
    {
        if ($storeCategoryName && !is_numeric($storeCategoryName)) {
            $category = $store->storeCategories()->firstOrCreate(
                ['name' => $storeCategoryName],
                ['slug' => Str::slug($storeCategoryName) . '-' . Str::random(4)]
            );
            return $category->id;
        }
        return $storeCategoryId ?: null;
    }
}
