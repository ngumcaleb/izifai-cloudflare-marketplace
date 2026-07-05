<x-admin-layout>
    <x-slot name="header">Withdrawal Request</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <a href="{{ route('admin.withdrawals.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-navy-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Withdrawals
        </a>

        @if(session('success'))
        <div class="bg-navy-900 border border-gold-500/30 text-white p-4 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
            <span class="text-xs font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="x-circle" class="w-4 h-4 text-rose-500"></i>
            <span class="text-xs font-semibold">{{ session('error') }}</span>
        </div>
        @endif

        @if($overWithdrawal && $withdrawal->status === 'pending')
        <div class="bg-rose-50 border-2 border-rose-200 rounded-2xl p-5 flex items-start gap-4">
            <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-rose-700">Insufficient Balance</h4>
                <p class="text-xs text-rose-600 mt-1 leading-relaxed">
                    The requested amount <strong>XAF {{ number_format($withdrawal->amount) }}</strong> exceeds the seller's available balance of <strong>XAF {{ number_format($availableBalance) }}</strong>.
                    This may indicate the balance was already used after this request was submitted. Review carefully before approving.
                </p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <!-- Main Details -->
            <div class="lg:col-span-3 space-y-6">
                <div class="admin-card p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-navy-800">Withdrawal Details</h2>
                            <p class="text-[10px] text-slate-400 font-medium">Requested {{ $withdrawal->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase
                            {{ $withdrawal->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                            {{ $withdrawal->status === 'approved' ? 'bg-blue-50 text-blue-600' : '' }}
                            {{ $withdrawal->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}
                            {{ $withdrawal->status === 'rejected' ? 'bg-rose-50 text-rose-600' : '' }}">
                            {{ $withdrawal->status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Seller</p>
                            <p class="text-sm font-bold text-navy-800">{{ $withdrawal->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $withdrawal->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Requested Amount</p>
                            <p class="text-2xl font-black {{ $overWithdrawal ? 'text-rose-600' : 'text-navy-800' }}">XAF {{ number_format($withdrawal->amount) }}</p>
                            @if($overWithdrawal)
                            <p class="text-[9px] text-rose-500 font-bold mt-1">⚠ Exceeds available balance</p>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mt-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Balance Before</p>
                                <p class="text-sm font-bold text-navy-800">XAF {{ number_format($withdrawal->balance_before ?? 0) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Payment Method</p>
                                <p class="text-sm font-bold text-navy-800">{{ $withdrawal->method ?? '—' }}</p>
                            </div>
                            @if($withdrawal->account_number)
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Account Number</p>
                                <p class="text-sm font-bold text-navy-800">{{ $withdrawal->account_number }}</p>
                            </div>
                            @endif
                            @if($withdrawal->account_name)
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Account Name</p>
                                <p class="text-sm font-bold text-navy-800">{{ $withdrawal->account_name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($withdrawal->admin_note)
                    <div class="border-t border-slate-100 pt-4 mt-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Admin Note</p>
                        <p class="text-sm text-slate-600">{{ $withdrawal->admin_note }}</p>
                    </div>
                    @endif

                    @if($withdrawal->processed_at)
                    <div class="border-t border-slate-100 pt-4 mt-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Processed By</p>
                        <p class="text-sm font-bold text-navy-800">
                            {{ $withdrawal->processor->name ?? 'Admin' }}
                            &middot; {{ $withdrawal->processed_at->format('M d, Y H:i') }}
                        </p>
                    </div>
                    @endif

                    @if($withdrawal->status === 'pending')
                    <div class="border-t border-slate-100 pt-6 mt-6 space-y-4">
                        <div class="flex flex-col md:flex-row gap-3">
                            <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="flex-1">
                                @csrf
                                <div class="space-y-2">
                                    <input type="text" name="admin_note" placeholder="Optional note (e.g. transaction ref)" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                                    <button type="submit" onclick="return confirm('Approve withdrawal of XAF {{ number_format($withdrawal->amount) }}?')"
                                            class="w-full py-3 {{ $overWithdrawal ? 'bg-slate-300 text-slate-500 cursor-not-allowed' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }} rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        Approve & Release XAF {{ number_format($withdrawal->amount) }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST" x-data="{ showReason: false }">
                            @csrf
                            <div class="flex flex-col gap-3">
                                <button type="button" @click="showReason = !showReason"
                                        class="w-full py-3 bg-white border-2 border-rose-200 text-rose-500 hover:bg-rose-50 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    Reject Withdrawal
                                </button>
                                <div x-show="showReason" x-cloak class="bg-rose-50 rounded-xl p-4 space-y-3 animate-in fade-in slide-in-from-top-2">
                                    <p class="text-[10px] font-bold text-rose-700 uppercase tracking-widest">Reason for rejection</p>
                                    <textarea name="reason" rows="2" placeholder="Explain why this withdrawal was rejected..." class="w-full p-3 bg-white border border-rose-200 rounded-lg text-xs font-medium focus:ring-2 focus:ring-rose-200 transition-all"></textarea>
                                    <div class="flex gap-2">
                                        <button type="submit" onclick="return confirm('Reject this withdrawal? No funds will be deducted.')"
                                                class="px-6 py-2.5 bg-rose-500 text-white rounded-lg text-[10px] font-bold hover:bg-rose-600 transition-all">
                                            Confirm Rejection
                                        </button>
                                        <button type="button" @click="showReason = false" class="px-6 py-2.5 bg-white text-slate-500 rounded-lg text-[10px] font-bold border border-slate-200 hover:bg-slate-50 transition-all">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Withdrawal History -->
                @if($withdrawalCount > 0)
                <div class="admin-card p-6">
                    <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest mb-4">Withdrawal History</h3>
                    <div class="flex items-center gap-6">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Total Withdrawn</p>
                            <p class="text-base font-black text-navy-800">XAF {{ number_format($totalWithdrawn) }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Withdrawals</p>
                            <p class="text-base font-black text-navy-800">{{ $withdrawalCount }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase">vs Earnings</p>
                            <p class="text-base font-black text-navy-800">{{ $withdrawalRatio }}%</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Wallet Snapshot Sidebar -->
            <div class="lg:col-span-2 space-y-6">
                <div class="admin-card p-6 bg-navy-900 border-none">
                    <h3 class="text-sm font-bold text-white mb-1">Wallet Snapshot</h3>
                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-widest mb-6">Live balance information</p>

                    <div class="space-y-5">
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                            <div>
                                <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest">Current Balance</p>
                                <p class="text-lg font-black text-white mt-1">XAF {{ number_format($wallet->balance ?? 0) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                                <i data-lucide="wallet" class="w-5 h-5 text-emerald-400"></i>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                            <div>
                                <p class="text-[9px] font-bold text-amber-400 uppercase tracking-widest">Locked in Escrow</p>
                                <p class="text-base font-bold text-white mt-1">XAF {{ number_format($wallet->locked_balance ?? 0) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center">
                                <i data-lucide="lock" class="w-5 h-5 text-amber-400"></i>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 {{ $overWithdrawal ? 'bg-rose-500/10 border-rose-500/30' : 'bg-emerald-500/10 border-emerald-500/30' }} rounded-xl border">
                            <div>
                                <p class="text-[9px] font-bold {{ $overWithdrawal ? 'text-rose-400' : 'text-emerald-400' }} uppercase tracking-widest">Available to Withdraw</p>
                                <p class="text-lg font-black {{ $overWithdrawal ? 'text-rose-400' : 'text-white' }} mt-1">XAF {{ number_format($availableBalance) }}</p>
                            </div>
                            <div class="w-10 h-10 {{ $overWithdrawal ? 'bg-rose-500/10' : 'bg-emerald-500/10' }} rounded-xl flex items-center justify-center">
                                <i data-lucide="{{ $overWithdrawal ? 'alert-triangle' : 'check-circle' }}" class="w-5 h-5 {{ $overWithdrawal ? 'text-rose-400' : 'text-emerald-400' }}"></i>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                            <div>
                                <p class="text-[9px] font-bold text-blue-400 uppercase tracking-widest">Total Lifetime Earnings</p>
                                <p class="text-base font-bold text-white mt-1">XAF {{ number_format($totalEarned) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-5 h-5 text-blue-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-white/10">
                        <div class="flex items-center justify-between text-[10px]">
                            <span class="text-slate-400 font-medium">Requested Amount</span>
                            <span class="font-bold {{ $overWithdrawal ? 'text-rose-400' : 'text-white' }}">XAF {{ number_format($withdrawal->amount) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[10px] mt-2">
                            <span class="text-slate-400 font-medium">Approval would leave</span>
                            <span class="font-bold {{ ($availableBalance - $withdrawal->amount) < 0 ? 'text-rose-400' : 'text-emerald-400' }}">
                                XAF {{ number_format(max(0, $availableBalance - $withdrawal->amount)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Safety Check -->
                <div class="admin-card p-6">
                    <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest mb-4">Safety Check</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-xl {{ $overWithdrawal ? 'bg-rose-50' : 'bg-emerald-50' }}">
                            <span class="text-[10px] font-bold text-slate-600">Balance covers request</span>
                            @if($overWithdrawal)
                            <span class="w-5 h-5 bg-rose-500 rounded-full flex items-center justify-center text-white"><i data-lucide="x" class="w-3 h-3"></i></span>
                            @else
                            <span class="w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center text-white"><i data-lucide="check" class="w-3 h-3"></i></span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl {{ $withdrawalRatio > 80 ? 'bg-amber-50' : 'bg-emerald-50' }}">
                            <span class="text-[10px] font-bold text-slate-600">Withdrawal ratio ({{ $withdrawalRatio }}% of earnings)</span>
                            @if($withdrawalRatio > 80)
                            <span class="w-5 h-5 bg-amber-500 rounded-full flex items-center justify-center text-white"><i data-lucide="alert-triangle" class="w-3 h-3"></i></span>
                            @else
                            <span class="w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center text-white"><i data-lucide="check" class="w-3 h-3"></i></span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl {{ $totalEarned > 0 ? 'bg-emerald-50' : 'bg-slate-50' }}">
                            <span class="text-[10px] font-bold text-slate-600">Has earnings history</span>
                            @if($totalEarned > 0)
                            <span class="w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center text-white"><i data-lucide="check" class="w-3 h-3"></i></span>
                            @else
                            <span class="w-5 h-5 bg-slate-300 rounded-full flex items-center justify-center text-white"><i data-lucide="minus" class="w-3 h-3"></i></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
