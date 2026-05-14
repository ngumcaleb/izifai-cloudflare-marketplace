<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReport;
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (!auth()->check()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Please log in to report this listing.'], 401);
            }
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        ProductReport::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? 'User reported this listing.',
            'status' => 'pending',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Thank you for your report. Our team will review this listing shortly.']);
        }

        return back()->with('success', 'Thank you for your report. Our team will review this listing shortly.');
    }
}
