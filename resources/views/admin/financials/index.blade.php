<x-admin-layout>
    <x-slot name="header">Financial Control Center</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="relative bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900 rounded-2xl p-6 md:p-10 overflow-hidden shadow-xl">
            <div class="absolute right-0 top-0 w-80 h-80 bg-emerald-500/5 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-gold-400/5 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <div class="inline-flex items-center gap-1.5 text-emerald-400 text-[8px] font-bold mb-3 uppercase tracking-widest">
                    <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                    Platform Treasury
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight mb-2">
                    Financial <span class="text-gold-400">Overview</span>
                </h2>
                <p class="text-xs md:text-sm text-slate-400 font-medium max-w-xl">
                    Real-time platform financial health, commission earnings, payout tracking, and cash flow management.
                </p>
            </div>
        </div>

        <!-- ═══ LIFETIME TOTALS ═══ -->
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-6 h-6 bg-navy-900 rounded-lg flex items-center justify-center text-white"><i data-lucide="globe" class="w-3.5 h-3.5"></i></div>
                <h3 class="text-xs font-bold text-navy-900 uppercase tracking-widest">Lifetime Totals</h3>
                <div class="flex-1 h-px bg-slate-100"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="admin-card p-5 relative overflow-hidden">
                    <div class="absolute right-2 top-2 w-16 h-16 bg-emerald-50 rounded-full"></div>
                    <div class="relative z-10">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Received</p>
                        <h3 class="text-xl md:text-2xl font-black text-navy-800">XAF {{ number_format($totalPaidIn) }}</h3>
                        <p class="text-[9px] text-slate-400 mt-1">All money buyers ever paid in</p>
                    </div>
                </div>
                <div class="admin-card p-5 relative overflow-hidden">
                    <div class="absolute right-2 top-2 w-16 h-16 bg-gold-50 rounded-full"></div>
                    <div class="relative z-10">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Platform Commission</p>
                        <h3 class="text-xl md:text-2xl font-black text-emerald-600">XAF {{ number_format($totalCommission) }}</h3>
                        <p class="text-[9px] text-gold-600 mt-1">{{ $commissionRate }}% of delivered orders</p>
                    </div>
                </div>
                <div class="admin-card p-5 relative overflow-hidden">
                    <div class="absolute right-2 top-2 w-16 h-16 bg-blue-50 rounded-full"></div>
                    <div class="relative z-10">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Paid to Sellers</p>
                        <h3 class="text-xl md:text-2xl font-black text-navy-800">XAF {{ number_format($totalPaidToSellers) }}</h3>
                        <p class="text-[9px] text-slate-400 mt-1">After commission deduction</p>
                    </div>
                </div>
                <div class="admin-card p-5 relative overflow-hidden">
                    <div class="absolute right-2 top-2 w-16 h-16 bg-rose-50 rounded-full"></div>
                    <div class="relative z-10">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Withdrawn by Sellers</p>
                        <h3 class="text-xl md:text-2xl font-black text-rose-600">XAF {{ number_format($totalWithdrawn) }}</h3>
                        <p class="text-[9px] text-rose-500 mt-1">Already sent out</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ CURRENT HOLDINGS ═══ -->
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-6 h-6 bg-navy-900 rounded-lg flex items-center justify-center text-white"><i data-lucide="wallet" class="w-3.5 h-3.5"></i></div>
                <h3 class="text-xs font-bold text-navy-900 uppercase tracking-widest">Current Holdings</h3>
                <div class="flex-1 h-px bg-slate-100"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="admin-card p-5">
                    <p class="text-[9px] font-bold text-amber-600 uppercase tracking-widest mb-1">In Escrow</p>
                    <h3 class="text-xl md:text-2xl font-black text-amber-600">XAF {{ number_format($totalLockedBalance) }}</h3>
                    <p class="text-[9px] text-slate-400 mt-1">{{ $activeOrdersCount }} active orders</p>
                </div>
                <div class="admin-card p-5">
                    <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mb-1">In Wallets</p>
                    <h3 class="text-xl md:text-2xl font-black text-emerald-600">XAF {{ number_format($totalSystemBalance) }}</h3>
                    <p class="text-[9px] text-slate-400 mt-1">{{ $usersWithBalance }}/{{ $walletHoldersCount }} wallets funded</p>
                </div>
                <div class="admin-card p-5">
                    <p class="text-[9px] font-bold text-rose-600 uppercase tracking-widest mb-1">Pending Withdrawal</p>
                    <h3 class="text-xl md:text-2xl font-black text-rose-600">XAF {{ number_format($pendingWithdrawalAmount) }}</h3>
                    <p class="text-[9px] text-rose-500 mt-1">{{ $pendingWithdrawalCount }} requests</p>
                </div>
                <div class="admin-card p-5 bg-navy-900 border-none">
                    <p class="text-[9px] font-bold text-gold-400 uppercase tracking-widest mb-1">Total Platform Holdings</p>
                    <h3 class="text-xl md:text-2xl font-black text-white">XAF {{ number_format($totalPlatformHoldings) }}</h3>
                    <p class="text-[9px] text-slate-400 mt-1">Escrow + Wallets — money in system</p>
                </div>
            </div>
        </div>

        <!-- ═══ NET CASH POSITION ═══ -->
        <div class="admin-card p-5 bg-gradient-to-r from-navy-900 to-navy-800 border-none">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest">Net Cash Position</p>
                    <h2 class="text-2xl md:text-3xl font-black text-white mt-1">XAF {{ number_format($netCashPosition) }}</h2>
                    <p class="text-[9px] text-slate-400 mt-1">Total Received − Withdrawn = what the platform holds at the bank</p>
                </div>
                <div class="flex gap-6 text-[10px]">
                    <div class="text-center">
                        <p class="text-emerald-400 font-bold text-lg">{{ $deliveredOrdersCount }}</p>
                        <p class="text-slate-400 font-medium">Orders Delivered</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gold-400 font-bold text-lg">{{ $commissionRate }}%</p>
                        <p class="text-slate-400 font-medium">Commission Rate</p>
                    </div>
                    <div class="text-center">
                        <p class="text-white font-bold text-lg">XAF {{ number_format($minWithdrawal) }}</p>
                        <p class="text-slate-400 font-medium">Min Withdrawal</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Monthly Revenue Chart -->
            <div class="admin-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-navy-800">Monthly Revenue</h3>
                        <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold">Last 12 Months</p>
                    </div>
                </div>
                @php
                    $maxRev = max(1, collect($monthlyRevenue)->max('revenue'));
                @endphp
                <div class="h-52 flex items-end gap-2 md:gap-3 px-1">
                    @foreach($monthlyRevenue as $month)
                    <div class="flex-1 flex flex-col items-center justify-end h-full gap-0.5">
                        @if($month['commission'] > 0)
                        <div class="w-full bg-gold-400 rounded-t" style="height: {{ max(2, ($month['commission'] / $maxRev) * 100) }}%" title="Commission: XAF {{ number_format($month['commission']) }}"></div>
                        @endif
                        <div class="w-full bg-emerald-500/70 rounded-t" style="height: {{ max(2, ($month['payouts'] / $maxRev) * 100) }}%" title="Payouts: XAF {{ number_format($month['payouts']) }}"></div>
                        <span class="text-[7px] font-bold text-slate-400 mt-1">{{ $month['label'] }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex mt-3 gap-4 text-[9px]">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-emerald-500/70"></span> Paid to Sellers</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-gold-400"></span> Commission</span>
                </div>
            </div>

            <!-- Cash Flow Summary -->
            <div class="admin-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-navy-800">Platform P&L Summary</h3>
                        <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold">Lifetime</p>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-navy-800">Revenue (Buyers Paid)</p>
                                <p class="text-[8px] text-slate-400">Total delivered order value</p>
                            </div>
                        </div>
                        <span class="text-sm font-black text-navy-800">XAF {{ number_format($grossRevenue) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600">
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-navy-800">Paid to Sellers</p>
                                <p class="text-[8px] text-slate-400">After commission deduction</p>
                            </div>
                        </div>
                        <span class="text-sm font-black text-rose-600">-XAF {{ number_format($totalPaidToSellers) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gold-50 rounded-xl border border-gold-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gold-100 rounded-lg flex items-center justify-center text-gold-600">
                                <i data-lucide="banknote" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-navy-800">Platform Earnings</p>
                                <p class="text-[8px] text-gold-600 font-medium">{{ $commissionRate }}% commission rate</p>
                            </div>
                        </div>
                        <span class="text-sm font-black text-emerald-600">+XAF {{ number_format($totalCommission) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Earning Stores -->
        <div class="admin-card overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-sm font-bold text-navy-800">Top Earning Merchants</h3>
                <a href="{{ route('admin.stores.index') }}" class="text-[10px] font-bold text-gold-500 uppercase tracking-widest">Merchant Hub</a>
            </div>
            @if($topStores->isNotEmpty())
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">#</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Store</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Owner</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Total Payout</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($topStores as $i => $store)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <span class="w-6 h-6 rounded-lg {{ $i < 3 ? 'bg-gold-100 text-gold-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center text-[10px] font-black">{{ $i + 1 }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-navy-800">{{ $store->store_name }}</td>
                            <td class="px-6 py-4 text-[11px] text-slate-500">{{ $store->owner_name }}</td>
                            <td class="px-6 py-4 text-right text-xs font-bold text-navy-800">XAF {{ number_format($store->total_payout) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="md:hidden divide-y divide-slate-50">
                @foreach($topStores as $i => $store)
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg {{ $i < 3 ? 'bg-gold-100 text-gold-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center text-[10px] font-black">{{ $i + 1 }}</span>
                        <div>
                            <h4 class="text-xs font-bold text-navy-800">{{ $store->store_name }}</h4>
                            <p class="text-[9px] text-slate-400">{{ $store->owner_name }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-navy-800">XAF {{ number_format($store->total_payout) }}</span>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-10 text-center text-slate-400 italic text-sm">No payout data yet. Orders need to be completed first.</div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Payouts -->
            <div class="admin-card overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50">
                    <h3 class="text-sm font-bold text-navy-800">Recent Payouts</h3>
                </div>
                @if($recentPayouts->isNotEmpty())
                <div class="divide-y divide-slate-50">
                    @foreach($recentPayouts as $payout)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/30 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 shrink-0">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-navy-800 truncate">{{ $payout->wallet->user->name ?? 'Unknown' }}</p>
                                <p class="text-[8px] text-slate-400 truncate">{{ Str::limit($payout->description ?? 'Payout', 50) }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-600 shrink-0">+XAF {{ number_format($payout->amount) }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-8 text-center text-slate-400 italic text-sm">No payouts yet.</div>
                @endif
            </div>

            <!-- Pending Withdrawals -->
            <div class="admin-card overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-navy-800">Pending Withdrawals</h3>
                    <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}" class="text-[10px] font-bold text-rose-500 uppercase tracking-widest">View All</a>
                </div>
                @if($recentWithdrawals->isNotEmpty())
                <div class="divide-y divide-slate-50">
                    @foreach($recentWithdrawals as $w)
                    <a href="{{ route('admin.withdrawals.show', $w) }}" class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/30 transition-colors group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600 shrink-0">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-navy-800 truncate group-hover:text-amber-600 transition-colors">{{ $w->user->name ?? 'Unknown' }}</p>
                                <p class="text-[8px] text-slate-400">{{ $w->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-rose-600 shrink-0">XAF {{ number_format($w->amount) }}</span>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="p-8 text-center">
                    <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">All withdrawals processed</p>
                    <p class="text-[9px] text-slate-300 mt-1">No pending requests</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
