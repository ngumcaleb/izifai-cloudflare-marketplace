<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReport;
use App\Models\Store;
use App\Models\StoreReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportProduct(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        $report = ProductReport::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? 'User reported this listing.',
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Report submitted. Our team will review it shortly.',
            'report' => $report,
        ], 201);
    }

    public function reportStore(Request $request, Store $store): JsonResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        $report = StoreReport::create([
            'user_id' => auth()->id(),
            'store_id' => $store->id,
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? 'User reported this store.',
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Report submitted. Our team will review it shortly.',
            'report' => $report,
        ], 201);
    }
}
