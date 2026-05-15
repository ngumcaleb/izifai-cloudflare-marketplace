<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdvertisementRequest;
use App\Models\Product;
use App\Models\PaymentMethod;

class AdController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $adRequests = AdvertisementRequest::with('product')
            ->where('store_id', $store->id)
            ->latest()
            ->get();

        $products = Product::where('store_id', $store->id)->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $adPricePerDay = (int) \App\Models\Setting::get('ad_price_per_day', 200);

        return view('seller.ads.index', compact('adRequests', 'products', 'paymentMethods', 'adPricePerDay'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'duration_days' => 'required|integer|min:1|max:30',
            'seller_notes' => 'nullable|string|max:500',
            'payment_sender_number' => 'required|string|min:9|max:15',
            'payment_proof' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $store = auth()->user()->store;
        $adPricePerDay = (int) \App\Models\Setting::get('ad_price_per_day', 200);
        $totalAmount = $adPricePerDay * $request->duration_days;

        // Ensure the product belongs to the store
        $product = Product::where('id', $request->product_id)
            ->where('store_id', $store->id)
            ->firstOrFail();

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'r2');
        }

        AdvertisementRequest::create([
            'product_id' => $product->id,
            'store_id' => $store->id,
            'type' => 'featured',
            'duration_days' => $request->duration_days,
            'status' => 'pending',
            'seller_notes' => $request->seller_notes,
            'payment_sender_number' => $request->payment_sender_number,
            'total_amount' => $totalAmount,
            'payment_proof' => $proofPath,
        ]);

        return back()->with('success', 'Promotion request submitted! Once we verify the payment of XAF ' . number_format($totalAmount) . ', your product will go live.');
    }
}
