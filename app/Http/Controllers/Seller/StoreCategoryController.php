<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreCategoryController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $categories = $store->storeCategories()
            ->whereNull('parent_id')
            ->with('children')
            ->latest()
            ->get();

        return view('seller.store-categories.index', compact('categories'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        $parentCategories = $store->storeCategories()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('seller.store-categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $store = auth()->user()->store;

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:store_categories,id',
            'type' => 'nullable|in:product,rental',
        ]);

        $store->storeCategories()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'parent_id' => $request->parent_id,
            'type' => $request->type ?? 'product',
        ]);

        return redirect()->back()
            ->with('success', 'Category created.');
    }

    public function edit($id)
    {
        $store = auth()->user()->store;
        $category = $store->storeCategories()->findOrFail($id);
        $parentCategories = $store->storeCategories()
            ->whereNull('parent_id')
            ->where('id', '!=', $id)
            ->orderBy('name')
            ->get();

        return view('seller.store-categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $store = auth()->user()->store;
        $category = $store->storeCategories()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:store_categories,id',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
        ];
        if ($request->has('parent_id')) {
            $data['parent_id'] = $request->parent_id;
        }
        $category->update($data);

        return redirect()->back()
            ->with('success', 'Category updated.');
    }

    public function destroy($id)
    {
        $store = auth()->user()->store;
        $category = $store->storeCategories()->findOrFail($id);

        $category->children()->update(['parent_id' => null]);
        $category->delete();

        return redirect()->back()
            ->with('success', 'Category deleted.');
    }
}
