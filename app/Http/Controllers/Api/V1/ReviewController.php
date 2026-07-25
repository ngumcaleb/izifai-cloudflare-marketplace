<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\RentalItem;
use App\Models\RentalReview;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\Store;
use App\Models\StoreReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Store $store): JsonResponse
    {
        if (auth()->id() === $store->user_id) {
            return response()->json([
                'message' => 'You cannot review your own store.',
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $review = StoreReview::create([
            'user_id' => auth()->id(),
            'store_id' => $store->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        $store->update([
            'rating' => $store->reviews()->avg('rating'),
        ]);

        return response()->json([
            'message' => 'Review submitted successfully.',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'user_name' => $review->user->name,
                'created_at' => $review->created_at,
            ],
        ], 201);
    }

    public function storeProduct(Request $request, Product $product): JsonResponse
    {
        if ($product->store->user_id === auth()->id()) {
            return response()->json(['message' => 'You cannot review your own product.'], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'images' => 'nullable|array',
        ]);

        $review = ProductReview::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'images' => $validated['images'] ?? [],
        ]);

        $product->update([
            'rating' => $product->reviews()->avg('rating'),
            'review_count' => $product->reviews()->count(),
        ]);

        return response()->json([
            'message' => 'Review submitted.',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'images' => $review->images ?? [],
                'user_name' => $review->user->name,
                'created_at' => $review->created_at,
            ],
        ], 201);
    }

    public function storeService(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'images' => 'nullable|array',
        ]);

        $review = ServiceReview::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'images' => $validated['images'] ?? [],
        ]);

        $service->update([
            'rating' => $service->reviews()->avg('rating'),
            'review_count' => $service->reviews()->count(),
        ]);

        return response()->json([
            'message' => 'Review submitted.',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'images' => $review->images ?? [],
                'user_name' => $review->user->name,
                'created_at' => $review->created_at,
            ],
        ], 201);
    }

    public function storeRental(Request $request, RentalItem $rentalItem): JsonResponse
    {
        if ($rentalItem->store->user_id === auth()->id()) {
            return response()->json(['message' => 'You cannot review your own rental item.'], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'images' => 'nullable|array',
        ]);

        $existing = RentalReview::where('rental_item_id', $rentalItem->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return response()->json(['message' => 'You have already reviewed this rental item.'], 409);
        }

        $review = RentalReview::create([
            'rental_item_id' => $rentalItem->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'images' => $validated['images'] ?? [],
        ]);

        $rentalItem->update([
            'rating' => $rentalItem->reviews()->avg('rating'),
            'review_count' => $rentalItem->reviews()->count(),
        ]);

        return response()->json([
            'message' => 'Review submitted.',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'images' => $review->images ?? [],
                'user_name' => $review->user->name,
                'created_at' => $review->created_at,
            ],
        ], 201);
    }

    public function index(string $targetType, int $targetId): JsonResponse
    {
        $model = match ($targetType) {
            'product' => ProductReview::with('user')->where('product_id', $targetId),
            'service' => ServiceReview::with('user')->where('service_id', $targetId),
            'store' => StoreReview::with('user')->where('store_id', $targetId),
            'rental_item' => RentalReview::with('user')->where('rental_item_id', $targetId),
            default => null,
        };

        if (!$model) {
            return response()->json(['message' => 'Invalid review type.'], 400);
        }

        $totalReviews = $model->count();
        $avgRating = $totalReviews > 0 ? round($model->avg('rating'), 1) : 0;
        $reviews = $model->latest()->paginate(20);

        return response()->json([
            'reviews' => collect($reviews->items())->map(fn($r) => [
                'id' => $r->id,
                'rating' => $r->rating,
                'comment' => $r->comment,
                'images' => $r->images ?? [],
                'helpful' => count($r->helpful ?? []),
                'is_helpful' => auth()->check() ? in_array(auth()->id(), $r->helpful ?? []) : false,
                'user_name' => $r->user->name,
                'created_at' => $r->created_at,
            ]),
            'avg_rating' => $avgRating,
            'total_reviews' => $totalReviews,
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'total' => $reviews->total(),
            ],
        ]);
    }

    private function findReview(int $id): ProductReview|ServiceReview|StoreReview|RentalReview|null
    {
        return ProductReview::with('user')->find($id)
            ?? ServiceReview::with('user')->find($id)
            ?? StoreReview::with('user')->find($id)
            ?? RentalReview::with('user')->find($id);
    }

    private function findReviewForUpdate(int $id): ProductReview|ServiceReview|StoreReview|RentalReview|null
    {
        return ProductReview::find($id)
            ?? ServiceReview::find($id)
            ?? StoreReview::find($id)
            ?? RentalReview::find($id);
    }

    public function show(int $id): JsonResponse
    {
        $review = $this->findReview($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found.'], 404);
        }

        return response()->json([
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'images' => $review->images ?? [],
                'helpful' => $review->helpful ?? 0,
                'user_name' => $review->user->name,
                'created_at' => $review->created_at,
            ],
        ]);
    }

    public function markHelpful(int $id): JsonResponse
    {
        $review = $this->findReviewForUpdate($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found.'], 404);
        }

        $helpful = $review->helpful ?? [];
        $userId = auth()->id();

        if (in_array($userId, $helpful)) {
            $helpful = array_values(array_filter($helpful, fn($hid) => $hid !== $userId));
        } else {
            $helpful[] = $userId;
        }

        $review->update(['helpful' => $helpful]);

        return response()->json([
            'helpful_count' => count($helpful),
            'is_helpful' => in_array($userId, $helpful),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $review = $this->findReviewForUpdate($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found.'], 404);
        }

        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted.']);
    }
}
