<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $payments = Transaction::with('order')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return response()->json([
            'payments' => collect($payments->items())->map(fn($t) => [
                'id' => $t->id,
                'order_number' => $t->order->order_number,
                'type' => $t->type,
                'amount' => (float) $t->amount,
                'currency' => $t->currency ?? 'XAF',
                'payment_method' => $t->payment_method,
                'reference' => $t->reference,
                'status' => $t->status,
                'created_at' => $t->created_at,
            ]),
            'pagination' => [
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
                'total' => $payments->total(),
            ],
        ]);
    }
}
