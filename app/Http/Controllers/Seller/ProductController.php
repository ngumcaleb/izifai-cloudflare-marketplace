<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $query = $store->products()->with('images', 'category');

        if ($request->filled('collection')) {
            $query->where('store_category_id', $request->collection);
        }

        $products = $query->latest()->get();
        $storeCategories = $store->storeCategories()->where('type', 'product')->withCount('products')->whereNull('parent_id')->orderBy('name')->get();

        $currentCollection = null;
        if ($request->filled('collection')) {
            $currentCollection = $storeCategories->firstWhere('id', $request->collection)
                ?? $store->storeCategories()->find($request->collection);
        }

        return view('seller.products.index', compact('products', 'storeCategories', 'store', 'currentCollection'));
    }

    public function create(Request $request)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $categories = Category::orderBy('name')->get();
        $storeCategories = $store->storeCategories()->where('type', 'product')->with('children')->whereNull('parent_id')->orderBy('name')->get();

        $selectedCategory = null;
        if ($request->filled('collection')) {
            $selectedCategory = $store->storeCategories()->where('type', 'product')->find($request->collection);
        }

        return view('seller.products.create', compact('categories', 'storeCategories', 'selectedCategory'));
    }

    public function store(Request $request)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'store_category_id' => 'nullable|exists:store_categories,id',
            'store_category_name' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,on_request',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'brand' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:100',
            'inventory' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'specs' => 'nullable|array',
            'specs.*.name' => 'nullable|string|max:255',
            'specs.*.value' => 'nullable|string|max:1000',
        ]);

        $storeCategoryId = $this->resolveStoreCategory($store, $request->store_category_id, $request->store_category_name);

        $product = $store->products()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'store_category_id' => $storeCategoryId,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'stock_status' => $request->stock_status,
            'colors' => $request->colors ?? [],
            'sizes' => $request->sizes ?? [],
            'brand' => $request->brand,
            'sku' => $request->sku,
            'inventory' => $request->inventory ?? 0,
            'status' => 'active',
            'approval_status' => 'approved',
            'views' => 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('product-images', 'r2');
                $product->images()->create([
                    'path' => $path,
                    'is_main' => $i === 0,
                ]);
            }
        }

        if ($request->filled('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['name']) || !empty($spec['value'])) {
                    $product->specifications()->create([
                        'key' => $spec['name'] ?? '',
                        'value' => $spec['value'] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $product = $store->products()->with('images', 'specifications')->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $storeCategories = $store->storeCategories()->where('type', 'product')->with('children')->whereNull('parent_id')->orderBy('name')->get();

        return view('seller.products.edit', compact('product', 'categories', 'storeCategories'));
    }

    public function update(Request $request, $id)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $product = $store->products()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'store_category_id' => 'nullable|exists:store_categories,id',
            'store_category_name' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,on_request',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'brand' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:100',
            'inventory' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'specs' => 'nullable|array',
            'specs.*.name' => 'nullable|string|max:255',
            'specs.*.value' => 'nullable|string|max:1000',
        ]);

        $storeCategoryId = $this->resolveStoreCategory($store, $request->store_category_id, $request->store_category_name);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'store_category_id' => $storeCategoryId,
            'price' => $request->price,
            'old_price' => $request->old_price ?: null,
            'stock_status' => $request->stock_status,
            'colors' => $request->colors ?? [],
            'sizes' => $request->sizes ?? [],
            'brand' => $request->brand,
            'sku' => $request->sku,
            'inventory' => $request->inventory ?? 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product-images', 'r2');
                $product->images()->create([
                    'path' => $path,
                    'is_main' => !$product->images()->where('is_main', true)->exists(),
                ]);
            }
        }

        if ($request->has('specs')) {
            $product->specifications()->delete();
            foreach ($request->specs as $spec) {
                if (!empty($spec['name']) || !empty($spec['value'])) {
                    $product->specifications()->create([
                        'key' => $spec['name'] ?? '',
                        'value' => $spec['value'] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'You do not have a store yet.');
        }

        $product = $store->products()->findOrFail($id);

        foreach ($product->images as $image) {
            if ($image->path) {
                Storage::disk('r2')->delete($image->path);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted.');
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
