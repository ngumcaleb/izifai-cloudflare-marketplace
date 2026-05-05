<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreReviewController extends Controller
{
    public function store(Request $request, Store $store)
    {
        if (Auth::id() === $store->user_id) {
            return back()->with('error', 'You cannot review your own store.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        StoreReview::create([
            'user_id' => Auth::id(),
            'store_id' => $store->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
}
