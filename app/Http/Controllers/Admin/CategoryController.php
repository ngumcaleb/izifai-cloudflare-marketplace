<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount(['products' => function ($q) {
            $q->whereHas('store', fn($sq) => $sq->where('status', 'active'));
        }])->with(['parent']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->parent_id) {
            if ($request->parent_id === 'none') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_id);
            }
        }

        $perPage = $request->input('per_page', 20);
        $categories = $query->orderBy('name')->paginate($perPage);

        $totalProducts = $categories->sum('products_count');

        $allCategories = Category::orderBy('name')->get();

        return view('admin.categories.index', compact('categories', 'totalProducts', 'allCategories'));
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'icon' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $category = Category::create($validated);

        AuditLogger::log('category.created', "Created category #{$category->id}: {$category->name}", $category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category "' . $validated['name'] . '" created successfully.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '!=', $category->id)->orderBy('name')->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $oldValues = $category->only(['name', 'slug', 'parent_id']);
        $category->update($validated);
        $newValues = $category->only(['name', 'slug', 'parent_id']);

        AuditLogger::log('category.updated', "Updated category #{$category->id}: {$category->name}", $category, $oldValues, $newValues);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category "' . $validated['name'] . '" updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete "' . $category->name . '" — it has ' . $category->products()->count() . ' product(s) assigned. Reassign or remove them first.');
        }

        $category->delete();

        AuditLogger::log('category.deleted', "Deleted category #{$category->id}: {$category->name}");

        return back()->with('success', 'Category deleted successfully.');
    }
}
