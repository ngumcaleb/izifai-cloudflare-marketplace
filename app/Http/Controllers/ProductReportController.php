<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReport;
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        ProductReport::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'reason' => $request->reason,
            'details' => $request->details ?? 'User reported this listing.',
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you for your report. Our team will review this listing shortly.');
    }
}
