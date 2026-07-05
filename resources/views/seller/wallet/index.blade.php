<x-seller-layout>
    <x-slot name="title">My Wallet</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">My Wallet</h1>
                <p class="text-[11px] text-gray-500 mt-0.5">Manage your earnings, track transactions, and withdraw funds to your mobile money account.</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-3 gap-2 md:gap-3">
            <a href="{{ route('seller.wallet.deposit') }}"
               class="flex items-center justify-center gap-1.5 md:gap-2 py-2.5 md:py-3.5 bg-white rounded-xl border border-gray-100/80 shadow-sm text-xs md:text-sm font-bold text-gray-700 hover:border-primary/30 hover:text-primary hover:shadow-md active:scale-[0.97] transition-all">
                <span class="material-symbols-outlined text-[16px] md:text-[18px]">add_circle</span>
                <span class="hidden sm:inline">Deposit</span>
                <span class="sm:hidden">Add</span>
            </a>
            <a href="{{ route('seller.wallet.withdraw') }}"
               class="flex items-center justify-center gap-1.5 md:gap-2 py-2.5 md:py-3.5 bg-white rounded-xl border border-gray-100/80 shadow-sm text-xs md:text-sm font-bold text-gray-700 hover:border-primary/30 hover:text-primary hover:shadow-md active:scale-[0.97] transition-all">
                <span class="material-symbols-outlined text-[16px] md:text-[18px]">output</span>
                Withdraw
            </a>
            <a href="{{ route('seller.wallet.transactions') }}"
               class="flex items-center justify-center gap-1.5 md:gap-2 py-2.5 md:py-3.5 bg-white rounded-xl border border-gray-100/80 shadow-sm text-xs md:text-sm font-bold text-gray-700 hover:border-primary/30 hover:text-primary hover:shadow-md active:scale-[0.97] transition-all">
                <span class="material-symbols-outlined text-[16px] md:text-[18px]">receipt_long</span>
                <span class="hidden sm:inline">History</span>
                <span class="sm:hidden">Log</span>
            </a>
        </div>

        {{-- Balance Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4">
            <div class="bg-gradient-to-br from-primary to-primary/80 text-white rounded-2xl p-4 md:p-5 shadow-sm col-span-2 sm:col-span-2">
                <p class="text-[11px] font-semibold uppercase tracking-wider opacity-80">Available for Withdrawal</p>
                <p class="text-3xl md:text-4xl font-black mt-1">{{ number_format($wallet->balance) }} <span class="text-sm font-bold opacity-80">XAF</span></p>
                <div class="flex items-center gap-2 mt-2 text-[11px] opacity-80">
                    <span class="material-symbols-outlined text-[14px]">account_balance_wallet</span>
                    <span>{{ $wallet->total_earned ? number_format($wallet->total_earned) . ' XAF total earned' : 'Start earning today' }}</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">In Escrow</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">lock</span>
                    </div>
                </div>
                <p class="text-xl md:text-2xl font-black text-gray-900">{{ number_format($wallet->locked_balance ?? 0) }}</p>
                <p class="text-[10px] text-gray-400 mt-0.5">XAF awaiting buyer confirmation</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Pending Withdrawal</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">hourglass</span>
                    </div>
                </div>
                <p class="text-xl md:text-2xl font-black text-gray-900">{{ number_format(abs($pendingAmount)) }}</p>
                <p class="text-[10px] text-gray-400 mt-0.5">XAF being processed</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Earned</span>
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                    </div>
                </div>
                <p class="text-xl md:text-2xl font-black text-gray-900">{{ number_format($wallet->total_earned ?? 0) }}</p>
                <p class="text-[10px] text-gray-400 mt-0.5">XAF lifetime earnings</p>
            </div>
        </div>

        {{-- How it works --}}
        <div class="bg-primary/5 border border-primary/10 rounded-2xl p-4 md:p-5">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0 mt-0.5">
                    <span class="material-symbols-outlined text-[18px]">info</span>
                </div>
                <div class="text-sm text-gray-600">
                    <p class="font-bold text-gray-900 mb-1">How your wallet works</p>
                    <p>When a customer buys from you, the amount is held in escrow until they confirm delivery. Once confirmed, the funds are released to your available balance minus a small commission. You can then withdraw your available balance to your mobile money account.</p>
                </div>
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80">
            <div class="flex items-center justify-between px-4 md:px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm md:text-base font-bold text-gray-900">Recent Transactions</h2>
                <a href="{{ route('seller.wallet.transactions') }}" class="text-xs font-semibold text-primary hover:underline">View All</a>
            </div>
            <div class="p-3 md:p-4">
                <div class="space-y-2 md:grid md:grid-cols-2 md:gap-3 md:space-y-0">
                    @forelse($recentTransactions as $txn)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100/70 transition-colors">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0
                                {{ $txn->type === 'escrow_release' ? 'bg-green-50 text-green-600' : '' }}
                                {{ $txn->type === 'ad_payment' ? 'bg-purple-50 text-purple-600' : '' }}
                                {{ $txn->type === 'withdrawal' ? 'bg-red-50 text-red-500' : '' }}
                                {{ $txn->type === 'deposit' ? 'bg-blue-50 text-blue-600' : '' }}">
                                <span class="material-symbols-outlined text-[18px]">
                                    {{ $txn->type === 'escrow_release' ? 'arrow_downward' : '' }}
                                    {{ $txn->type === 'ad_payment' ? 'campaign' : '' }}
                                    {{ $txn->type === 'withdrawal' ? 'arrow_upward' : '' }}
                                    {{ $txn->type === 'deposit' ? 'add' : '' }}
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $txn->description }}</p>
                                <div class="flex items-center gap-2 text-[11px] text-gray-400 mt-0.5">
                                    <span>{{ $txn->created_at->format('M d, Y') }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="capitalize">{{ str_replace('_', ' ', $txn->type) }}</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-black
                                    {{ $txn->amount > 0 ? 'text-green-600' : ($txn->amount < 0 ? 'text-red-500' : 'text-gray-400') }}">
                                    @if($txn->amount > 0)
                                        +{{ number_format($txn->amount) }}
                                    @elseif($txn->amount < 0)
                                        {{ number_format($txn->amount) }}
                                    @else
                                        —
                                    @endif
                                </p>
                                <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold uppercase mt-0.5
                                    {{ $txn->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $txn->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $txn->status === 'failed' ? 'bg-red-50 text-red-700' : '' }}">{{ $txn->status }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 px-4 py-8 text-center">
                            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                <span class="material-symbols-outlined text-3xl text-gray-300">account_balance_wallet</span>
                            </div>
                            <p class="text-sm font-bold text-gray-900">No transactions yet</p>
                            <p class="text-xs text-gray-500 mt-1">When you make sales or pay for ads, they'll appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
