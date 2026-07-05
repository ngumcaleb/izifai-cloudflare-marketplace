<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\AdvertisementRequest;
use App\Models\Product;
use App\Models\Service;
use App\Models\RentalItem;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\FapshiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create')
                ->with('error', 'Create a store first.');
        }

        $dailyRate = Setting::get('ad_price_per_day', 500);
        $products = $store->products()->where('status', 'active')->latest()->get();
        $services = $store->services()->where('status', 'active')->latest()->get();
        $rentals = $store->rentalItems()->where('status', 'published')->latest()->get();
        $adRequests = $store->advertisementRequests()->with('promotable')->latest()->get();

        return view('seller.ads.index', compact(
            'dailyRate', 'products', 'services', 'rentals', 'adRequests'
        ));
    }

    public function store(Request $request)
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create')
                ->with('error', 'Create a store first.');
        }

        $dailyRate = Setting::get('ad_price_per_day', 500);

        $request->validate([
            'promotable_type' => 'required|in:product,service,rental,custom',
            'promotable_id' => 'required_if:promotable_type,product,service,rental|nullable|integer',
            'title' => 'required_if:promotable_type,custom|nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'days' => 'required|integer|min:1|max:365',
            'phone' => 'required|string|max:20',
        ]);

        $totalAmount = $dailyRate * $request->days;

        $typeMap = [
            'product' => Product::class,
            'service' => Service::class,
            'rental' => RentalItem::class,
        ];

        if ($request->promotable_type === 'custom') {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('ads', 'r2');
            }

            $ad = $store->advertisementRequests()->create([
                'promotable_type' => null,
                'promotable_id' => null,
                'title' => $request->title,
                'image' => $imagePath,
                'description' => $request->description,
                'days' => $request->days,
                'daily_rate' => $dailyRate,
                'total_amount' => $totalAmount,
                'payer_phone' => $request->phone,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);
        } else {
            $modelClass = $typeMap[$request->promotable_type];
            $item = $store->{$request->promotable_type . 's'}()
                ->where('id', $request->promotable_id)
                ->first();

            if (!$item) {
                return back()->with('error', 'Item not found.');
            }

            $ad = $store->advertisementRequests()->create([
                'promotable_type' => $modelClass,
                'promotable_id' => $item->id,
                'title' => $item->name,
                'days' => $request->days,
                'daily_rate' => $dailyRate,
                'total_amount' => $totalAmount,
                'payer_phone' => $request->phone,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);
        }

        $fapshi = new FapshiService;
        $result = $fapshi->initiateDirectPay(
            $totalAmount,
            $request->phone,
            "Ad: {$ad->title}",
            ['ad_id' => $ad->id]
        );

        if (isset($result['transId'])) {
            $ad->update([
                'payment_reference' => $result['transId'],
                'payment_status' => 'processing',
            ]);

            return redirect()->route('seller.ads.show', $ad->id)
                ->with('success', 'Payment initiated. Complete the prompt on your phone.');
        }

        return redirect()->route('seller.ads.index')
            ->with('error', $result['message'] ?? 'Payment failed. Try again.');
    }

    public function show($id)
    {
        $store = auth()->user()->store;
        $ad = $store->advertisementRequests()->with('promotable')->findOrFail($id);

        return view('seller.ads.show', compact('ad'));
    }

    public function checkPayment($id)
    {
        $store = auth()->user()->store;
        $ad = $store->advertisementRequests()->findOrFail($id);

        if (!$ad->payment_reference) {
            return response()->json(['status' => 'no_reference']);
        }

        $fapshi = new FapshiService;
        $result = $fapshi->verifyTransaction($ad->payment_reference);

        if (($result['status'] ?? '') === 'success') {
            $ad->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'ad_payment',
                'amount' => 0,
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance,
                'description' => "Paid for ad: {$ad->title} ({$ad->days} days) — {$ad->total_amount} XAF via Fapshi",
                'reference' => $ad->payment_reference,
                'status' => 'completed',
            ]);

            return response()->json([
                'status' => 'paid',
                'redirect' => route('seller.ads.show', $ad->id),
            ]);
        }

        return response()->json(['status' => $result['status'] ?? 'pending']);
    }
}
