<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RentalItem;
use App\Models\RentalTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalTransactionController extends Controller
{
    public function index(): JsonResponse
    {
        $transactions = RentalTransaction::with(['rentalItem', 'customer'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(20);

        return response()->json([
            'transactions' => collect($transactions->items())->map(fn($t) => [
                'id' => $t->id,
                'rental_id' => $t->rental_item_id,
                'rental_name' => $t->rentalItem->name,
                'customer_id' => $t->customer_id,
                'customer_name' => $t->customer->name,
                'start_date' => $t->start_date,
                'end_date' => $t->end_date,
                'total_amount' => (float) $t->total_amount,
                'deposit_amount' => (float) $t->deposit_amount,
                'status' => $t->status,
                'payment_status' => $t->payment_status,
                'notes' => $t->notes,
                'conversation_id' => $t->conversation_id,
                'created_at' => $t->created_at,
            ]),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'rental_item_id' => 'required|exists:rental_items,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:500',
        ]);

        $rentalItem = RentalItem::findOrFail($validated['rental_item_id']);

        $days = now()->parse($validated['start_date'])->diffInDays(now()->parse($validated['end_date'])) + 1;
        $multiplier = match ($rentalItem->billing_unit) {
            'hourly' => $days * 24,
            'daily' => $days,
            'weekly' => ceil($days / 7),
            'monthly' => ceil($days / 30),
            default => $days,
        };
        $totalAmount = $rentalItem->rate * max(1, $multiplier);

        $transaction = RentalTransaction::create([
            'rental_item_id' => $rentalItem->id,
            'customer_id' => auth()->id(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_amount' => $totalAmount,
            'deposit_amount' => $rentalItem->deposit ?? 0,
            'status' => 'pending',
            'payment_status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Rental request submitted.',
            'transaction' => $transaction->load('rentalItem'),
        ], 201);
    }

    public function show(RentalTransaction $rentalTransaction): JsonResponse
    {
        if ($rentalTransaction->customer_id !== auth()->id() && $rentalTransaction->rentalItem->store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $rentalTransaction->load(['rentalItem.store', 'customer']);

        return response()->json([
            'transaction' => [
                'id' => $rentalTransaction->id,
                'rental_id' => $rentalTransaction->rental_item_id,
                'rental_name' => $rentalTransaction->rentalItem->name,
                'store_id' => $rentalTransaction->rentalItem->store_id,
                'store_name' => $rentalTransaction->rentalItem->store->name,
                'store_slug' => $rentalTransaction->rentalItem->store->slug,
                'customer_id' => $rentalTransaction->customer_id,
                'customer_name' => $rentalTransaction->customer->name,
                'start_date' => $rentalTransaction->start_date,
                'end_date' => $rentalTransaction->end_date,
                'total_amount' => (float) $rentalTransaction->total_amount,
                'deposit_amount' => (float) $rentalTransaction->deposit_amount,
                'status' => $rentalTransaction->status,
                'payment_status' => $rentalTransaction->payment_status,
                'notes' => $rentalTransaction->notes,
                'conversation_id' => $rentalTransaction->conversation_id,
                'created_at' => $rentalTransaction->created_at,
                'updated_at' => $rentalTransaction->updated_at,
            ],
        ]);
    }

    public function cancel(RentalTransaction $rentalTransaction): JsonResponse
    {
        if ($rentalTransaction->customer_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if (!in_array($rentalTransaction->status, ['pending', 'awaiting_payment'])) {
            return response()->json(['message' => 'Rental cannot be cancelled at this stage.'], 400);
        }

        $rentalTransaction->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Rental cancelled.']);
    }

    public function approve(RentalTransaction $rentalTransaction): JsonResponse
    {
        $store = auth()->user()->store;
        if (!$store || $rentalTransaction->rentalItem->store_id !== $store->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($rentalTransaction->status !== 'pending') {
            return response()->json(['message' => 'Booking cannot be approved.'], 400);
        }

        $rentalTransaction->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        return response()->json(['message' => 'Booking approved.']);
    }

    public function reject(Request $request, RentalTransaction $rentalTransaction): JsonResponse
    {
        $store = auth()->user()->store;
        if (!$store || $rentalTransaction->rentalItem->store_id !== $store->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($rentalTransaction->status !== 'pending') {
            return response()->json(['message' => 'Booking cannot be rejected.'], 400);
        }

        $rentalTransaction->update([
            'status' => 'rejected',
            'notes' => $request->input('reason', $rentalTransaction->notes),
        ]);

        return response()->json(['message' => 'Booking rejected.']);
    }

    public function markReturned(RentalTransaction $rentalTransaction): JsonResponse
    {
        if ($rentalTransaction->customer_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($rentalTransaction->status !== 'active') {
            return response()->json(['message' => 'Rental is not currently active.'], 400);
        }

        $rentalTransaction->update(['status' => 'returned']);

        return response()->json(['message' => 'Item marked as returned.']);
    }

    public function incoming(): JsonResponse
    {
        $store = auth()->user()->store;
        $storeIds = $store ? [$store->id] : [];

        $transactions = RentalTransaction::with(['rentalItem', 'customer'])
            ->whereIn('rental_item_id', function ($q) use ($storeIds) {
                $q->select('id')->from('rental_items')->whereIn('store_id', $storeIds);
            })
            ->latest()
            ->paginate(20);

        return response()->json([
            'transactions' => collect($transactions->items())->map(fn($t) => [
                'id' => $t->id,
                'rental_name' => $t->rentalItem->name,
                'customer_name' => $t->customer->name,
                'start_date' => $t->start_date,
                'end_date' => $t->end_date,
                'total_amount' => (float) $t->total_amount,
                'status' => $t->status,
                'created_at' => $t->created_at,
            ]),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }
}
