<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Store;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function authorize(): void
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }
    }

    public function dashboard(): JsonResponse
    {
        $this->authorize();

        $totalUsers = User::count();
        $totalSellers = User::whereHas('store')->count();
        $totalBuyers = User::whereDoesntHave('store')->where('role', '!=', 'Superadmin')->count();
        $totalStores = Store::count();
        $totalProducts = Product::count();
        $totalServices = Service::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $completedRevenue = (float) Order::where('status', 'delivered')->sum('total_amount');

        return response()->json([
            'dashboard' => [
                'total_users' => $totalUsers,
                'total_sellers' => $totalSellers,
                'total_buyers' => $totalBuyers,
                'total_stores' => $totalStores,
                'total_products' => $totalProducts,
                'total_services' => $totalServices,
                'total_orders' => $totalOrders,
                'pending_orders' => $pendingOrders,
                'delivered_orders' => $deliveredOrders,
                'completed_revenue' => $completedRevenue,
            ],
        ]);
    }

    public function financialOverview(): JsonResponse
    {
        $this->authorize();

        // Total money that has flowed through the system (sum of all completed order amounts)
        $totalPaidIn = (float) Order::whereIn('status', ['delivered', 'processing', 'shipped'])
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Total locked in escrow (pending release to sellers)
        $totalLocked = (float) Wallet::sum('locked_balance');

        // Total available balance across all seller wallets (earnings not yet withdrawn)
        $totalAvailableInWallets = (float) Wallet::sum('balance');

        // Total already withdrawn by sellers
        $totalWithdrawnBySellers = (float) WalletTransaction::where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum(DB::raw('ABS(amount)'));

        // Platform fee percentage
        $platformFeePct = (float) (Setting::get('platform_fee_percentage', '5'));

        // Platform earnings = total paid in completed orders * fee %
        // This is what the platform has earned in commission
        $platformEarned = round($totalPaidIn * ($platformFeePct / 100), 2);

        // Net platform balance: what the platform account actually holds
        // = total paid in - total withdrawn by sellers - locked in escrow
        $netPlatformBalance = $totalPaidIn - $totalWithdrawnBySellers - $totalLocked;

        // Pending withdrawal requests
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();
        $pendingWithdrawalAmount = (float) Withdrawal::where('status', 'pending')->sum('amount');

        // Monthly stats for chart
        $monthlyRevenue = Order::where('status', 'delivered')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_amount) as total")
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->map(fn ($r) => [
                'month' => $r->month,
                'total' => (float) $r->total,
                'platform_fee' => round((float) $r->total * ($platformFeePct / 100), 2),
            ]);

        return response()->json([
            'overview' => [
                'total_paid_in' => $totalPaidIn,
                'total_locked_in_escrow' => $totalLocked,
                'total_available_in_wallets' => $totalAvailableInWallets,
                'total_withdrawn_by_sellers' => $totalWithdrawnBySellers,
                'platform_fee_percentage' => $platformFeePct,
                'platform_earned' => $platformEarned,
                'net_platform_balance' => $netPlatformBalance,
                'pending_withdrawals_count' => $pendingWithdrawals,
                'pending_withdrawal_amount' => $pendingWithdrawalAmount,
                'currency' => Setting::get('platform_currency', 'XAF'),
            ],
            'monthly_revenue' => $monthlyRevenue,
        ]);
    }

    public function withdrawalRequests(Request $request): JsonResponse
    {
        $this->authorize();

        $query = Withdrawal::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->latest()->paginate(20);

        return response()->json([
            'withdrawals' => collect($withdrawals->items())->map(fn ($w) => [
                'id' => $w->id,
                'user_id' => $w->user_id,
                'user_name' => $w->user->name,
                'user_email' => $w->user->email,
                'amount' => (float) $w->amount,
                'balance_before' => (float) $w->balance_before,
                'method' => $w->method,
                'account_number' => $w->account_number,
                'account_name' => $w->account_name,
                'status' => $w->status,
                'admin_note' => $w->admin_note,
                'created_at' => $w->created_at,
                'processed_at' => $w->processed_at,
                'processed_by' => $w->processor?->name,
            ]),
            'pagination' => [
                'current_page' => $withdrawals->currentPage(),
                'last_page' => $withdrawals->lastPage(),
                'total' => $withdrawals->total(),
            ],
        ]);
    }

    public function approveWithdrawal(Request $request, Withdrawal $withdrawal): JsonResponse
    {
        $this->authorize();

        if ($withdrawal->status !== 'pending') {
            return response()->json(['message' => 'Withdrawal already processed.'], 400);
        }

        $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();

        if (! $wallet || $wallet->balance < $withdrawal->amount) {
            return response()->json(['message' => 'Insufficient balance in seller wallet.'], 400);
        }

        // Deduct from wallet
        $wallet->decrement('balance', $withdrawal->amount);

        // Record wallet transaction
        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'withdrawal',
            'amount' => -$withdrawal->amount,
            'balance_before' => $wallet->balance + $withdrawal->amount,
            'balance_after' => $wallet->balance,
            'description' => "Withdrawal to {$withdrawal->method} ({$withdrawal->account_number})",
            'reference' => 'WTH-'.strtoupper(uniqid()),
            'status' => 'completed',
            'order_id' => null,
        ]);

        // Mark withdrawal as completed
        $withdrawal->update([
            'status' => 'completed',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_note' => $request->input('admin_note'),
        ]);

        NotificationHelper::withdrawalApproved(
            $withdrawal->user_id,
            (float) $withdrawal->amount,
            $request->input('admin_note')
        );

        return response()->json([
            'message' => 'Withdrawal approved and processed.',
            'withdrawal' => [
                'id' => $withdrawal->id,
                'status' => 'completed',
                'processed_at' => $withdrawal->processed_at,
            ],
        ]);
    }

    public function rejectWithdrawal(Request $request, Withdrawal $withdrawal): JsonResponse
    {
        $this->authorize();

        if ($withdrawal->status !== 'pending') {
            return response()->json(['message' => 'Withdrawal already processed.'], 400);
        }

        $withdrawal->update([
            'status' => 'rejected',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_note' => $request->input('admin_note', 'Rejected by admin'),
        ]);

        NotificationHelper::withdrawalRejected(
            $withdrawal->user_id,
            (float) $withdrawal->amount,
            $request->input('admin_note')
        );

        return response()->json([
            'message' => 'Withdrawal rejected.',
            'withdrawal' => [
                'id' => $withdrawal->id,
                'status' => 'rejected',
            ],
        ]);
    }

    public function updatePlatformFee(Request $request): JsonResponse
    {
        $this->authorize();

        $validated = $request->validate([
            'platform_fee_percentage' => 'required|numeric|min:0|max:100',
        ]);

        Setting::set('platform_fee_percentage', (string) $validated['platform_fee_percentage']);

        return response()->json([
            'message' => 'Platform fee updated.',
            'platform_fee_percentage' => (float) Setting::get('platform_fee_percentage'),
        ]);
    }

    public function platformSettings(Request $request): JsonResponse
    {
        $this->authorize();

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'min_withdrawal' => 'numeric|min:100',
                'platform_support_email' => 'email',
                'platform_name' => 'string|max:100',
            ]);

            foreach ($validated as $key => $value) {
                Setting::set($key, (string) $value);
            }
        }

        return response()->json([
            'settings' => [
                'platform_fee_percentage' => (float) Setting::get('platform_fee_percentage', '5'),
                'platform_name' => Setting::get('platform_name', 'IZIFAI'),
                'platform_currency' => Setting::get('platform_currency', 'XAF'),
                'min_withdrawal' => (float) Setting::get('min_withdrawal', '1000'),
                'platform_support_email' => Setting::get('platform_support_email', 'support@izifai.com'),
            ],
        ]);
    }

    public function users(Request $request): JsonResponse
    {
        $this->authorize();

        $query = User::with('store.wallet');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('email', 'LIKE', "%{$q}%")
                    ->orWhere('phone', 'LIKE', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            if ($request->role === 'seller') {
                $query->whereHas('store');
            } elseif ($request->role === 'buyer') {
                $query->whereDoesntHave('store');
            } else {
                $query->where('role', $request->role);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(20);

        return response()->json([
            'users' => collect($users->items())->map(fn ($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'phone' => $u->phone,
                'role' => $u->role,
                'status' => $u->status,
                'verification_level' => $u->verification_level,
                'trust_score' => (float) $u->trust_score,
                'store_name' => $u->store?->name,
                'has_store' => $u->store !== null,
                'wallet_balance' => (float) ($u->wallet?->balance ?? 0),
                'wallet_locked' => (float) ($u->wallet?->locked_balance ?? 0),
                'total_withdrawn' => (float) WalletTransaction::whereHas('wallet', fn ($q) => $q->where('user_id', $u->id))
                    ->where('type', 'withdrawal')->where('status', 'completed')
                    ->sum(\DB::raw('ABS(amount)')),
                'created_at' => $u->created_at,
            ]),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'total' => $users->total(),
            ],
        ]);
    }

    public function updateUserStatus(Request $request, User $user): JsonResponse
    {
        $this->authorize();

        $validated = $request->validate([
            'status' => 'required|in:active,suspended,banned',
        ]);

        $user->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'User status updated.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'status' => $user->status,
            ],
        ]);
    }
}
