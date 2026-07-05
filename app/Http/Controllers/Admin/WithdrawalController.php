<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with(['user']);

        if ($request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->latest()->paginate(20);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load(['user', 'processor']);

        $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();
        $availableBalance = $wallet ? ($wallet->balance ?? 0) : 0;

        $totalWithdrawn = Withdrawal::where('user_id', $withdrawal->user_id)
            ->where('status', 'completed')
            ->sum('amount');

        $withdrawalCount = Withdrawal::where('user_id', $withdrawal->user_id)
            ->where('status', 'completed')
            ->count();

        $totalEarned = $wallet->total_earned ?? 0;
        $withdrawalRatio = $totalEarned > 0 ? round(($totalWithdrawn / $totalEarned) * 100, 1) : 0;

        $overWithdrawal = $withdrawal->amount > $availableBalance;

        return view('admin.withdrawals.show', compact(
            'withdrawal', 'wallet', 'availableBalance',
            'totalWithdrawn', 'withdrawalCount', 'totalEarned',
            'withdrawalRatio', 'overWithdrawal'
        ));
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Invalid withdrawal request.');
        }

        $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();
        if (!$wallet || $wallet->balance < $withdrawal->amount) {
            return back()->with('error', 'Insufficient balance in seller wallet.');
        }

        $admin = auth()->guard('admin')->user();

        DB::beginTransaction();
        try {
            $wallet->decrement('balance', $withdrawal->amount);

            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'withdrawal',
                'amount' => -$withdrawal->amount,
                'balance_before' => $wallet->balance + $withdrawal->amount,
                'balance_after' => $wallet->balance,
                'status' => 'completed',
                'description' => 'Withdrawal approved by admin',
            ]);

            $withdrawal->update([
                'status' => 'completed',
                'processed_by' => $admin->id,
                'processed_at' => now(),
                'admin_note' => $request->admin_note ?? 'Approved by admin',
            ]);

            DB::commit();

            AuditLogger::log('withdrawal.approved', "Approved withdrawal #{$withdrawal->id}: " . number_format($withdrawal->amount, 2) . " XAF", $withdrawal, ['status' => 'pending'], ['status' => 'completed']);

            NotificationHelper::withdrawalApproved(
                $withdrawal->user_id,
                (float) $withdrawal->amount,
                $request->admin_note
            );

            return back()->with('success', 'Withdrawal approved and funds released.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve withdrawal: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Invalid withdrawal request.');
        }

        $request->validate(['reason' => 'nullable|string|max:500']);

        $admin = auth()->guard('admin')->user();

        $withdrawal->update([
            'status' => 'rejected',
            'admin_note' => $request->reason ?? 'Rejected by admin',
            'processed_by' => $admin->id,
            'processed_at' => now(),
        ]);

        AuditLogger::log('withdrawal.rejected', "Rejected withdrawal #{$withdrawal->id}: " . number_format($withdrawal->amount, 2) . " XAF", $withdrawal, ['status' => 'pending'], ['status' => 'rejected']);

        NotificationHelper::withdrawalRejected(
            $withdrawal->user_id,
            (float) $withdrawal->amount,
            $request->reason
        );

        return back()->with('success', 'Withdrawal rejected. No funds were deducted.');
    }
}
