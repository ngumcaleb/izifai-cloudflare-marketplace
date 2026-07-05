<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::with(['children' => function ($q) {
            $q->withCount([
                'products' => fn($pq) => $pq->whereHas('store', fn($sq) => $sq->where('status', 'active')),
                'services' => fn($sq) => $sq->whereHas('store', fn($ssq) => $ssq->where('status', 'active')),
            ]);
        }])
            ->whereNull('parent_id')
            ->withCount([
                'products' => fn($q) => $q->whereHas('store', fn($sq) => $sq->where('status', 'active')),
                'services' => fn($q) => $q->whereHas('store', fn($sq) => $sq->where('status', 'active')),
            ])
            ->orderBy('name')
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'icon' => $c->icon,
                'image_url' => $c->image_url,
                'products_count' => $c->products_count,
                'services_count' => $c->services_count,
                'children' => $c->children->map(fn($child) => [
                    'id' => $child->id,
                    'name' => $child->name,
                    'slug' => $child->slug,
                    'icon' => $child->icon,
                    'image_url' => $child->image_url,
                    'products_count' => $child->products_count,
                    'services_count' => $child->services_count,
                ]),
            ]);

        return response()->json(['categories' => $categories]);
    }

    public function show($slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $children = $category->children()
            ->withCount(['products' => fn($q) => $q->whereHas('store', fn($sq) => $sq->where('status', 'active'))])
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'products_count' => $c->products_count,
            ]);

        return response()->json([
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => $category->icon,
                'image_url' => $category->image_url,
                'parent' => $category->parent ? [
                    'id' => $category->parent->id,
                    'name' => $category->parent->name,
                    'slug' => $category->parent->slug,
                ] : null,
            ],
            'children' => $children,
        ]);
    }
}
