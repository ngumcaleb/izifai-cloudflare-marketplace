<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SavedProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SavedProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::whereHas('savedUsers', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->with(['images', 'store'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'products' => collect($products->items())->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => (float) $p->price,
                'old_price' => (float) $p->old_price,
                'stock_status' => $p->stock_status,
                'main_image_url' => $p->mainImage?->url ?? $p->images->first()?->url,
                'store_name' => $p->store?->name,
                'store_slug' => $p->store?->slug,
                'is_favorite' => true,
            ]),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
                'has_more' => $products->hasMorePages(),
            ],
        ]);
    }

    public function toggle(Product $product): JsonResponse
    {
        $user = auth()->user();
        $exists = SavedProduct::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($exists) {
            $exists->delete();
            $favorited = false;
        } else {
            SavedProduct::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $favorited = true;
        }

        return response()->json([
            'favorited' => $favorited,
            'count' => $product->savedUsers()->count(),
        ]);
    }
}
