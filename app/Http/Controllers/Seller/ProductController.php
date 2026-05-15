<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private function getOrCreateStore()
    {
        $user = auth()->user();
        $store = $user->store;

        if (!$store) {
            $store = Store::create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Store",
                'slug' => Str::slug($user->name . ' store') . '-' . Str::random(5),
                'whatsapp_number' => $user->phone ?? '000000000',
            ]);
        }

        return $store;
    }

    public function index()
    {
        $products = $this->getOrCreateStore()->products()->with(['images', 'category'])->latest()->get();
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all(); // Simplified for now
        return view('seller.products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock_status' => 'nullable|string|in:in_stock,out_of_stock,on_request',
            'description' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
            'spec_names.*' => 'nullable|string',
            'spec_values.*' => 'nullable|string',
        ]);

        $store = $this->getOrCreateStore();

        $product = $store->products()->create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'price' => $request->price,
            'old_price' => $request->old_price,
            'stock_status' => $request->stock_status ?? 'in_stock',
            'description' => $request->description,
            'colors' => $request->colors ?? [],
            'sizes' => $request->sizes ?? [],
        ]);

        // Handle Images
        if ($request->hasFile('images')) {
            $mainIndex = $request->input('main_image_index', 0);
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'r2');
                $product->images()->create([
                    'path' => $path,
                    'is_main' => (int)$index === (int)$mainIndex,
                ]);
            }
        }

        if ($request->has('spec_names')) {
            foreach ($request->spec_names as $index => $name) {
                if (!empty($name) && !empty($request->spec_values[$index])) {
                    $product->specifications()->create([
                        'key' => $name,
                        'value' => $request->spec_values[$index],
                    ]);
                }
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Product posted successfully!');
    }

    public function edit($id)
    {
        $store = $this->getOrCreateStore();
        $product = $store->products()->with(['specifications', 'images'])->findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $store = $this->getOrCreateStore();
        $product = $store->products()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock_status' => 'nullable|string|in:in_stock,out_of_stock,on_request',
            'description' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
            'spec_names.*' => 'nullable|string',
            'spec_values.*' => 'nullable|string',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'stock_status' => $request->stock_status ?? 'in_stock',
            'description' => $request->description,
            'colors' => $request->colors ?? [],
            'sizes' => $request->sizes ?? [],
        ]);

        // Handle Images
        if ($request->hasFile('images')) {
            foreach ($product->images as $img) {
                \Illuminate\Support\Facades\Storage::disk('r2')->delete($img->path);
                $img->delete();
            }

            $mainIndex = $request->input('main_image_index', 0);
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'r2');
                $product->images()->create([
                    'path' => $path,
                    'is_main' => (int)$index === (int)$mainIndex,
                ]);
            }
        }

        if ($request->has('spec_names')) {
            $product->specifications()->delete();
            foreach ($request->spec_names as $index => $name) {
                if (!empty($name) && !empty($request->spec_values[$index])) {
                    $product->specifications()->create([
                        'key' => $name,
                        'value' => $request->spec_values[$index],
                    ]);
                }
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $store = $this->getOrCreateStore();
        $product = $store->products()->findOrFail($id);

        foreach ($product->images as $img) {
            \Illuminate\Support\Facades\Storage::disk('r2')->delete($img->path);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully!');
    }
}
