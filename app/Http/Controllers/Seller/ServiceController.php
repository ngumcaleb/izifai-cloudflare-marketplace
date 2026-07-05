<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\ServicePackage;
use App\Models\Category;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = auth()->user()->store->services()
            ->with(['images', 'category', 'packages'])
            ->latest()
            ->get();

        return view('seller.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::where('type', 'service')->get();
        $storeCategories = auth()->user()->store->storeCategories()->with('children')->whereNull('parent_id')->orderBy('name')->get();

        return view('seller.services.create', compact('categories', 'storeCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'store_category_id' => 'nullable|exists:store_categories,id',
            'store_category_name' => 'nullable|string|max:255',
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
        $store = auth()->user()->store;
        $storeCategoryId = $this->resolveStoreCategory($store, $request->store_category_id, $request->store_category_name);

        $service = Service::create([
            'store_id' => $store->id,
            'category_id' => $categoryId,
            'store_category_id' => $storeCategoryId,
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

        return redirect()->route('seller.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit($id)
    {
        $service = auth()->user()->store->services()
            ->with(['images', 'packages', 'category'])
            ->findOrFail($id);

        $categories = Category::where('type', 'service')->get();
        $storeCategories = auth()->user()->store->storeCategories()->with('children')->whereNull('parent_id')->orderBy('name')->get();

        return view('seller.services.edit', compact('service', 'categories', 'storeCategories'));
    }

    public function update(Request $request, $id)
    {
        $service = auth()->user()->store->services()->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|exists:categories,id',
            'store_category_id' => 'nullable|exists:store_categories,id',
            'store_category_name' => 'nullable|string|max:255',
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

        $storeCategoryId = $this->resolveStoreCategory(auth()->user()->store, $request->store_category_id, $request->store_category_name);

        $service->update(array_merge($request->only([
            'name', 'description', 'category_id', 'starting_price',
            'delivery_time', 'status',
        ]), ['store_category_id' => $storeCategoryId]));

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

        if ($request->hasFile('images')) {
            foreach ($service->images as $img) {
                Storage::disk('r2')->delete($img->path);
                $img->delete();
            }

            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('services', 'r2');
                ServiceImage::create([
                    'service_id' => $service->id,
                    'path' => $path,
                    'is_main' => $i === 0,
                ]);
            }
        }

        return redirect()->route('seller.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = auth()->user()->store->services()->findOrFail($id);

        foreach ($service->images as $img) {
            Storage::disk('r2')->delete($img->path);
            $img->delete();
        }

        $service->packages()->delete();
        $service->delete();

        return redirect()->route('seller.services.index')
            ->with('success', 'Service deleted successfully.');
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
