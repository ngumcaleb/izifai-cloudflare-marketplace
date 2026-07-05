<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show(): JsonResponse
    {
        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
        $minWithdrawal = (float) Setting::get('min_withdrawal', '1000');

        return response()->json([
            'wallet' => [
                'id' => $wallet->id,
                'balance' => (float) $wallet->balance,
                'locked_balance' => (float) ($wallet->locked_balance ?? 0),
                'available_balance' => (float) $wallet->balance,
                'total_earned' => (float) ($wallet->total_earned ?? 0),
                'min_withdrawal' => $minWithdrawal,
                'pending' => (float) WalletTransaction::where('wallet_id', $wallet->id)
                    ->where('status', 'pending')
                    ->sum('amount'),
                'pending_withdrawal' => (float) Withdrawal::where('user_id', auth()->id())
                    ->where('status', 'pending')
                    ->sum('amount'),
            ],
        ]);
    }

    public function transactions(Request $request): JsonResponse
    {
        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);

        $query = WalletTransaction::where('wallet_id', $wallet->id);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(20);

        return response()->json([
            'transactions' => collect($transactions->items())->map(fn($t) => [
                'id' => $t->id,
                'type' => $t->type,
                'amount' => (float) $t->amount,
                'balance_before' => (float) $t->balance_before,
                'balance_after' => (float) $t->balance_after,
                'description' => $t->description,
                'reference' => $t->reference,
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

    public function deposit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);

        $transaction = WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'deposit',
            'amount' => $validated['amount'],
            'balance_before' => $wallet->balance,
            'balance_after' => $wallet->balance + $validated['amount'],
            'description' => 'Wallet deposit via ' . $validated['payment_method'],
            'reference' => $validated['reference'] ?? 'DEP-' . strtoupper(uniqid()),
            'status' => 'completed',
        ]);

        $wallet->increment('balance', $validated['amount']);

        return response()->json([
            'message' => 'Deposit successful.',
            'transaction' => $transaction,
            'balance' => (float) $wallet->fresh()->balance,
        ]);
    }

    public function withdraw(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'method' => 'required|string|in:mtn_momo,orange_money,bank',
            'account_number' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
        $minWithdrawal = (float) Setting::get('min_withdrawal', '1000');
        $availableBalance = (float) $wallet->balance;

        if ($availableBalance < $validated['amount']) {
            return response()->json(['message' => 'Insufficient available balance.'], 400);
        }

        if ($validated['amount'] < $minWithdrawal) {
            return response()->json([
                'message' => "Minimum withdrawal amount is {$minWithdrawal} FCFA.",
            ], 400);
        }

        // Check for pending withdrawal
        $pendingExists = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($pendingExists) {
            return response()->json([
                'message' => 'You already have a pending withdrawal request.',
            ], 400);
        }

        // Create withdrawal request (admin must approve)
        $withdrawal = Withdrawal::create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'balance_before' => $wallet->balance,
            'method' => $validated['method'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'] ?? auth()->user()->name,
            'status' => 'pending',
        ]);

        NotificationHelper::withdrawalRequested(auth()->id(), (float) $validated['amount']);

        return response()->json([
            'message' => 'Withdrawal request submitted for admin approval.',
            'withdrawal' => [
                'id' => $withdrawal->id,
                'amount' => (float) $withdrawal->amount,
                'method' => $withdrawal->method,
                'status' => $withdrawal->status,
                'created_at' => $withdrawal->created_at,
            ],
            'balance' => (float) $wallet->fresh()->balance,
        ]);
    }

    public function paymentMethods(): JsonResponse
    {
        $methods = PaymentMethod::where('is_active', true)->get()->map(fn($m) => [
            'id' => $m->id,
            'name' => $m->name,
            'icon' => $m->icon,
            'account_number' => $m->number,
            'account_name' => $m->account_name,
        ]);

        return response()->json([
            'payment_methods' => $methods,
        ]);
    }
}
