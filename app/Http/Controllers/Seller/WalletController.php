<?php

namespace App\Http\Controllers\Seller;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);

        $recentTransactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->latest()
            ->take(5)
            ->get();

        $pendingAmount = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->sum('amount');

        return view('seller.wallet.index', compact(
            'wallet', 'recentTransactions', 'pendingAmount'
        ));
    }

    public function transactions(Request $request)
    {
        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);

        $query = WalletTransaction::where('wallet_id', $wallet->id);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        return view('seller.wallet.transactions', compact('transactions'));
    }

    public function depositForm()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('seller.wallet.deposit', compact('wallet', 'paymentMethods'));
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'deposit',
            'amount' => $validated['amount'],
            'balance_before' => $wallet->balance,
            'balance_after' => $wallet->balance + $validated['amount'],
            'description' => 'Deposit via ' . $validated['payment_method'],
            'reference' => $validated['reference'],
            'status' => 'pending',
        ]);

        return redirect()->route('seller.wallet.index')
            ->with('success', 'Deposit request submitted. Your wallet will be credited once the transfer is verified.');
    }

    public function withdrawForm()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('seller.wallet.withdraw', compact('wallet', 'paymentMethods'));
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'method' => 'required|string|in:mtn_momo,orange_money,bank',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
        ]);

        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
        $minWithdrawal = (float) Setting::get('min_withdrawal', '1000');

        if ($wallet->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient balance.'])->withInput();
        }

        if ($validated['amount'] < $minWithdrawal) {
            return back()->withErrors(['amount' => "Minimum withdrawal amount is {$minWithdrawal} FCFA."])->withInput();
        }

        $pendingExists = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($pendingExists) {
            return back()->withErrors(['amount' => 'You already have a pending withdrawal request.'])->withInput();
        }

        Withdrawal::create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'balance_before' => $wallet->balance,
            'method' => $validated['method'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'status' => 'pending',
        ]);

        NotificationHelper::withdrawalRequested(auth()->id(), (float) $validated['amount']);

        return redirect()->route('seller.wallet.index')
            ->with('success', 'Withdrawal request submitted for admin approval. Balance will be deducted upon approval.');
    }
}
