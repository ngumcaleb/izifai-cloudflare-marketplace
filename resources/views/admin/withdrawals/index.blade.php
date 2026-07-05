<x-admin-layout>
    <x-slot name="header">Withdrawal Requests</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Withdrawal <span class="text-gold-400">Requests</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Approve or reject seller withdrawal requests and manage payouts.
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-navy-900 border border-gold-500/30 text-white p-4 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
        <span class="text-xs font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="x-circle" class="w-4 h-4 text-rose-500"></i>
        <span class="text-xs font-semibold">{{ session('error') }}</span>
    </div>
    @endif

    <div class="space-y-6">
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.withdrawals.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by seller name or email..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                </div>
                <div class="flex gap-2">
                    <select name="status" class="px-4 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">Filter</button>
                </div>
            </form>
        </div>

        <div class="admin-card overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Seller</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Method</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($withdrawals as $w)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-navy-800 shrink-0">
                                        {{ substr($w->user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[12px] font-bold text-navy-800 truncate">{{ $w->user->name }}</h4>
                                        <p class="text-[9px] text-slate-400 truncate">{{ $w->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-navy-800">XAF {{ number_format($w->amount) }}</td>
                            <td class="px-6 py-4 text-[11px] text-slate-500">{{ $w->method ?? '—' }}</td>
                            <td class="px-6 py-4 text-[11px] text-slate-500">{{ $w->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase
                                    {{ $w->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                    {{ $w->status === 'approved' ? 'bg-blue-50 text-blue-600' : '' }}
                                    {{ $w->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}
                                    {{ $w->status === 'rejected' ? 'bg-rose-50 text-rose-600' : '' }}">
                                    {{ $w->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($w->status === 'pending')
                                    <form action="{{ route('admin.withdrawals.approve', $w) }}" method="POST" class="inline" onsubmit="return confirm('Approve withdrawal of XAF {{ number_format($w->amount) }} from {{ $w->user->name }}?')">
                                        @csrf
                                        <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-all inline-flex" title="Approve">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    <div x-data="{ open: false }" class="relative inline">
                                        <button @click="open = true" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition-all inline-flex" title="Reject">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                                            <div @click.stop class="bg-white rounded-2xl p-6 w-96 shadow-2xl border border-slate-100">
                                                <h4 class="text-sm font-bold text-navy-800 mb-1">Reject Withdrawal</h4>
                                                <p class="text-xs text-slate-500 mb-4">XAF {{ number_format($w->amount) }} from {{ $w->user->name }}</p>
                                                <form action="{{ route('admin.withdrawals.reject', $w) }}" method="POST">
                                                    @csrf
                                                    <textarea name="reason" rows="2" placeholder="Reason for rejection (optional)..." class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-medium focus:ring-2 focus:ring-rose-200 transition-all mb-4"></textarea>
                                                    <div class="flex gap-2 justify-end">
                                                        <button type="button" @click="open = false" class="px-4 py-2 text-[10px] font-bold text-slate-500 bg-slate-50 rounded-lg hover:bg-slate-100 transition-all">Cancel</button>
                                                        <button type="submit" class="px-4 py-2 text-[10px] font-bold text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition-all">Confirm Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <a href="{{ route('admin.withdrawals.show', $w) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all inline-flex" title="View details">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-slate-400 italic text-sm">No withdrawal requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-slate-50">
                @forelse($withdrawals as $w)
                <div class="p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-navy-800">
                                {{ substr($w->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-navy-800">{{ $w->user->name }}</p>
                                <p class="text-[9px] text-slate-400">{{ $w->user->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-navy-800">XAF {{ number_format($w->amount) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] text-slate-500">{{ $w->created_at->format('M d') }}</span>
                            <span class="px-1.5 py-0.5 rounded text-[7px] font-bold uppercase
                                {{ $w->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                {{ $w->status === 'approved' ? 'bg-blue-50 text-blue-600' : '' }}
                                {{ $w->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}
                                {{ $w->status === 'rejected' ? 'bg-rose-50 text-rose-600' : '' }}">
                                {{ $w->status }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1">
                            @if($w->status === 'pending')
                            <form action="{{ route('admin.withdrawals.approve', $w) }}" method="POST" class="inline" onsubmit="return confirm('Approve withdrawal of XAF {{ number_format($w->amount) }}?')">
                                @csrf
                                <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg"><i data-lucide="check-circle" class="w-3.5 h-3.5"></i></button>
                            </form>
                            @endif
                            <a href="{{ route('admin.withdrawals.show', $w) }}" class="p-1.5 bg-slate-50 text-slate-400 rounded-lg"><i data-lucide="chevron-right" class="w-3.5 h-3.5"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No withdrawal requests found.</div>
                @endforelse
            </div>
        </div>

        @if($withdrawals->hasPages())
            <div>{{ $withdrawals->links('partials.pagination') }}</div>
        @endif
    </div>
</x-admin-layout>
