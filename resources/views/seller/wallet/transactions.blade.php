<x-seller-layout>
    <x-slot name="title">Transaction History</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Transaction History</h1>
                <p class="text-[11px] text-gray-500 mt-0.5">View your complete wallet activity. Filter by type to find specific transactions.</p>
            </div>
            <a href="{{ route('seller.wallet.index') }}" class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Wallet
            </a>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-2xl p-3 md:p-4 shadow-sm border border-gray-100/80">
            <form method="GET" class="flex flex-wrap items-center gap-3">
                <select name="type" class="h-10 bg-gray-50 border border-gray-200 rounded-xl px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                    <option value="">All Types</option>
                    <option value="escrow_release" {{ request('type') === 'escrow_release' ? 'selected' : '' }}>Sales</option>
                    <option value="ad_payment" {{ request('type') === 'ad_payment' ? 'selected' : '' }}>Ad Payments</option>
                    <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>Withdrawals</option>
                </select>
                <button type="submit" class="h-10 px-4 bg-primary text-white rounded-xl text-xs font-bold hover:opacity-90 transition-all">Filter</button>
                @if(request()->filled('type'))
                    <a href="{{ route('seller.wallet.transactions') }}" class="text-xs text-gray-500 hover:text-primary">Clear</a>
                @endif
            </form>
        </div>

        {{-- Transactions Grid --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80">
            <div class="p-3 md:p-4">
                <div class="space-y-2 md:grid md:grid-cols-2 md:gap-3 md:space-y-0">
                    @forelse($transactions as $txn)
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
                                    <span>{{ $txn->created_at->format('M d, Y H:i') }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="capitalize">{{ str_replace('_', ' ', $txn->type) }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase
                                        {{ $txn->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                                        {{ $txn->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                        {{ $txn->status === 'failed' ? 'bg-red-50 text-red-700' : '' }}">{{ $txn->status }}</span>
                                </div>
                                @if($txn->reference)
                                    <p class="text-[10px] text-gray-400 mt-0.5 font-mono">Ref: {{ $txn->reference }}</p>
                                @endif
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
                                <p class="text-[10px] text-gray-400">Bal: {{ number_format($txn->balance_after) }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 px-4 py-8 text-center">
                            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                <span class="material-symbols-outlined text-3xl text-gray-300">receipt_long</span>
                            </div>
                            <p class="text-sm font-bold text-gray-900">No transactions found</p>
                            <p class="text-xs text-gray-500 mt-1">Try changing your filter.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        @if($transactions->hasPages())
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100/80">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-seller-layout>
