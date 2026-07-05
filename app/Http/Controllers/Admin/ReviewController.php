<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ServiceReview;
use App\Models\StoreReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        // Product Reviews
        $productQuery = ProductReview::with(['product', 'user']);
        if ($request->search) {
            $productQuery->where(function($q) use ($request) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhere('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('product', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
            });
        }
        if ($request->rating) {
            $productQuery->where('rating', $request->rating);
        }
        if ($request->date_from) {
            $productQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $productQuery->whereDate('created_at', '<=', $request->date_to);
        }
        $productReviews = $productQuery->latest()->paginate($perPage, ['*'], 'product_page');

        // Service Reviews
        $serviceQuery = ServiceReview::with(['service', 'user']);
        if ($request->search) {
            $serviceQuery->where(function($q) use ($request) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhere('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('service', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
            });
        }
        if ($request->rating) {
            $serviceQuery->where('rating', $request->rating);
        }
        if ($request->date_from) {
            $serviceQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $serviceQuery->whereDate('created_at', '<=', $request->date_to);
        }
        $serviceReviews = $serviceQuery->latest()->paginate($perPage, ['*'], 'service_page');

        // Store Reviews
        $storeQuery = StoreReview::with(['store', 'user']);
        if ($request->search) {
            $storeQuery->where(function($q) use ($request) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhere('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('store', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
            });
        }
        if ($request->rating) {
            $storeQuery->where('rating', $request->rating);
        }
        if ($request->date_from) {
            $storeQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $storeQuery->whereDate('created_at', '<=', $request->date_to);
        }
        $storeReviews = $storeQuery->latest()->paginate($perPage, ['*'], 'store_page');

        return view('admin.reviews.index', compact('productReviews', 'serviceReviews', 'storeReviews'));
    }

    public function destroyProductReview(ProductReview $review)
    {
        $review->delete();
        AuditLogger::log('review.deleted', "Deleted product review #{$review->id} (rating: {$review->rating})");
        return back()->with('success', 'Product review deleted.');
    }

    public function destroyServiceReview(ServiceReview $review)
    {
        $review->delete();
        AuditLogger::log('review.deleted', "Deleted service review #{$review->id} (rating: {$review->rating})");
        return back()->with('success', 'Service review deleted.');
    }

    public function destroyStoreReview(StoreReview $review)
    {
        $review->delete();
        AuditLogger::log('review.deleted', "Deleted store review #{$review->id} (rating: {$review->rating})");
        return back()->with('success', 'Store review deleted.');
    }
}
