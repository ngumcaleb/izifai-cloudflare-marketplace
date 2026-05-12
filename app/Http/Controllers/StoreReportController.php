<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreReport;
use Illuminate\Http\Request;

class StoreReportController extends Controller
{
    public function store(Request $request, Store $store)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        StoreReport::create([
            'user_id' => auth()->id(),
            'store_id' => $store->id,
            'reason' => $request->reason,
            'details' => $request->details ?? 'User reported this business.',
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you for your report. Our team will review this business shortly.');
    }
}
