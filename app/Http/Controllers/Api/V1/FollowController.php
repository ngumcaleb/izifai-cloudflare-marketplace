<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Store;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type', 'stores');

        $follows = Follow::with('followable')
            ->where('user_id', auth()->id())
            ->where('followable_type', $this->getModelClass($type))
            ->latest()
            ->paginate(20);

        return response()->json([
            'follows' => collect($follows->items())->map(fn($f) => [
                'id' => $f->id,
                'type' => $type,
                'name' => $f->followable->name,
                'slug' => $f->followable->slug,
                'logo_url' => $f->followable instanceof Store ? $f->followable->logo_url : null,
                'is_verified' => $f->followable instanceof Store ? $f->followable->is_verified : null,
                'created_at' => $f->created_at,
            ]),
            'pagination' => [
                'current_page' => $follows->currentPage(),
                'last_page' => $follows->lastPage(),
                'total' => $follows->total(),
            ],
        ]);
    }

    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'followable_type' => 'required|string|in:store,product,service',
            'followable_id' => 'required|integer',
        ]);

        $modelClass = $this->getModelClass($validated['followable_type']);
        $modelClass::findOrFail($validated['followable_id']);

        $existing = Follow::where('user_id', auth()->id())
            ->where('followable_type', $modelClass)
            ->where('followable_id', $validated['followable_id'])
            ->first();

        if ($existing) {
            $existing->delete();
            $following = false;
        } else {
            Follow::create([
                'user_id' => auth()->id(),
                'followable_type' => $modelClass,
                'followable_id' => $validated['followable_id'],
            ]);
            $following = true;
        }

        return response()->json([
            'following' => $following,
        ]);
    }

    private function getModelClass(string $type): string
    {
        return match ($type) {
            'store' => Store::class,
            'product' => Product::class,
            'service' => Service::class,
            default => Store::class,
        };
    }
}
