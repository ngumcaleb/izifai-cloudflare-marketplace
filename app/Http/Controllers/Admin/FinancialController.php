<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Models\Order;
use App\Models\User;
use App\Models\Setting;

class FinancialController extends Controller
{
    public function index()
    {
        $commissionRate = (float) Setting::get('platform_fee_percentage', Setting::get('commission_rate', 10));
        $minWithdrawal = (float) Setting::get('min_withdrawal', 1000);

        // ── Current Holdings ──
        $totalSystemBalance = Wallet::sum('balance');
        $totalLockedBalance = Wallet::sum('locked_balance');
        $totalPlatformHoldings = $totalSystemBalance + $totalLockedBalance;

        // ── Lifetime Totals ──
        $totalPaidIn = Order::where('payment_status', 'paid')->sum('total_amount');
        $grossRevenue = Order::where('status', 'delivered')->sum('total_amount');

        $totalWithdrawnOld = WalletTransaction::where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum(DB::raw('ABS(amount)'));

        $totalWithdrawnNew = Withdrawal::where('status', 'completed')->sum('amount');

        $totalWithdrawn = $totalWithdrawnOld + $totalWithdrawnNew;

        $totalPaidToSellers = WalletTransaction::where('type', 'escrow_release')
            ->where('status', 'completed')
            ->sum('amount');

        $totalCommissionCollected = WalletTransaction::where('type', 'commission')
            ->where('status', 'completed')
            ->sum(DB::raw('ABS(amount)'));

        // Use actual collected commission if available, otherwise estimate
        $totalCommission = $totalCommissionCollected > 0
            ? $totalCommissionCollected
            : ($grossRevenue > 0 ? $grossRevenue * ($commissionRate / 100) : 0);

        // ── Pending ──
        $pendingWithdrawalAmount = Withdrawal::where('status', 'pending')->sum('amount');
        $pendingWithdrawalCount = Withdrawal::where('status', 'pending')->count();

        // ── Derived ──
        $netCashPosition = $totalPaidIn - $totalWithdrawn;
        $totalDeposits = WalletTransaction::where('type', 'deposit')
            ->where('status', 'completed')
            ->sum('amount');
        $netCashFlow = $totalDeposits - $totalWithdrawn;

        // ── Counts ──
        $usersWithBalance = Wallet::where('balance', '>', 0)->count();
        $walletHoldersCount = Wallet::count();
        $activeOrdersCount = Order::where('escrow_status', 'held')->count();
        $deliveredOrdersCount = Order::where('status', 'delivered')->count();

        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $monthRevenue = Order::where('status', 'delivered')
                ->whereBetween('delivered_at', [$monthStart, $monthEnd])
                ->sum('total_amount');

            $monthPayouts = WalletTransaction::where('type', 'escrow_release')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');

            $monthlyRevenue[] = [
                'label' => $date->format('M'),
                'year' => $date->format('Y'),
                'revenue' => $monthRevenue,
                'payouts' => $monthPayouts,
                'commission' => $monthRevenue - $monthPayouts,
            ];
        }

        $topStores = DB::table('wallet_transactions')
            ->join('wallets', 'wallet_transactions.wallet_id', '=', 'wallets.id')
            ->join('users', 'wallets.user_id', '=', 'users.id')
            ->join('stores', 'users.id', '=', 'stores.user_id')
            ->where('wallet_transactions.type', 'escrow_release')
            ->where('wallet_transactions.status', 'completed')
            ->select(
                'stores.id as store_id',
                'stores.name as store_name',
                'users.name as owner_name',
                DB::raw('SUM(wallet_transactions.amount) as total_payout')
            )
            ->groupBy('stores.id', 'stores.name', 'users.name')
            ->orderByDesc('total_payout')
            ->limit(10)
            ->get();

        $totalPayoutAllStores = $topStores->sum('total_payout') > 0
            ? WalletTransaction::where('type', 'escrow_release')->where('status', 'completed')->sum('amount')
            : 0;

        $recentPayouts = WalletTransaction::with(['wallet.user'])
            ->where('type', 'escrow_release')
            ->where('status', 'completed')
            ->latest()
            ->limit(10)
            ->get();

        $recentWithdrawals = Withdrawal::with(['user'])
            ->where('status', 'pending')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.financials.index', compact(
            'totalSystemBalance',
            'totalLockedBalance',
            'totalPlatformHoldings',
            'totalPaidIn',
            'totalDeposits',
            'totalWithdrawn',
            'grossRevenue',
            'totalPaidToSellers',
            'totalCommission',
            'totalCommissionCollected',
            'pendingWithdrawalAmount',
            'pendingWithdrawalCount',
            'usersWithBalance',
            'walletHoldersCount',
            'netCashPosition',
            'netCashFlow',
            'commissionRate',
            'minWithdrawal',
            'activeOrdersCount',
            'deliveredOrdersCount',
            'monthlyRevenue',
            'topStores',
            'totalPayoutAllStores',
            'recentPayouts',
            'recentWithdrawals',
        ));
    }
}
