<x-admin-layout>
    <x-slot name="header">Safety Queue</x-slot>

    <!-- Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/security-guard-monitoring-surveillance-cameras_23-2148908914.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Safety <span class="text-gold-400">Reports</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Monitor and resolve user complaints about products and businesses.
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-navy-900 border border-gold-500/30 text-white p-3 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
        <span class="text-xs font-bold uppercase tracking-wider">{{ session('success') }}</span>
    </div>
    @endif

    <div x-data="{ tab: 'products' }" class="space-y-6">
        <!-- Tab Navigation -->
        <div class="flex p-1 bg-slate-100 rounded-xl w-fit">
            <button @click="tab = 'products'" 
                    :class="tab === 'products' ? 'bg-white text-navy-800 shadow-sm' : 'text-slate-500'"
                    class="px-6 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">
                Products ({{ $productReports->total() }})
            </button>
            <button @click="tab = 'stores'" 
                    :class="tab === 'stores' ? 'bg-white text-navy-800 shadow-sm' : 'text-slate-500'"
                    class="px-6 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">
                Businesses ({{ $storeReports->total() }})
            </button>
        </div>

        <!-- Filter Bar -->
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search reporter, item, or reason..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select name="reason" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Reasons</option>
                            @foreach($reasons as $reason)
                                <option value="{{ $reason }}" {{ request('reason') == $reason ? 'selected' : '' }}>{{ $reason }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <select name="per_page" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <input type="hidden" name="tab" x-bind:value="tab">
                        <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">Filter</button>
                        @if(request()->anyFilled(['search', 'reason', 'date_from', 'date_to', 'per_page']))
                            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Product Reports -->
        <div x-show="tab === 'products'" class="space-y-4">
            <div class="hidden md:block admin-card overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Product</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Reason</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Reporter</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($productReports as $report)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden shrink-0">
                                        @if($report->product->mainImage)
<img src="{{ $report->product->mainImage->url }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i data-lucide="package" class="w-5 h-5"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[12px] font-bold text-navy-800 line-clamp-1">{{ $report->product->name }}</h4>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $report->product->store->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2 py-1 bg-rose-50 text-rose-600 text-[9px] font-bold uppercase rounded-lg">{{ $report->reason }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[11px] font-bold text-slate-600">{{ $report->user->name }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] text-slate-400 font-bold">{{ $report->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('admin.reports.show', ['type' => 'product', 'id' => $report->id]) }}" class="p-2 bg-slate-50 text-navy-800 hover:bg-gold-400 hover:text-white rounded-lg transition-all inline-block">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm font-medium">No reports found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List (Card Design) -->
            <div class="md:hidden space-y-3">
                @forelse($productReports as $report)
                <div class="admin-card p-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden shrink-0 border border-slate-50">
                             @if($report->product->mainImage)
                                <img src="{{ $report->product->mainImage->url }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-[11px] font-bold text-navy-800 truncate mb-1">{{ $report->product->name }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="px-1.5 py-0.5 bg-rose-50 text-rose-500 text-[8px] font-bold uppercase rounded">{{ $report->reason }}</span>
                                <span class="text-[8px] text-slate-400 font-bold uppercase">{{ $report->created_at->format('M d') }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.show', ['type' => 'product', 'id' => $report->id]) }}" class="w-9 h-9 bg-slate-50 rounded-lg flex items-center justify-center text-navy-800 shrink-0">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest">No reports found.</div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $productReports->appends(request()->query())->links('partials.pagination') }}
            </div>
        </div>

        <!-- Store Reports -->
        <div x-show="tab === 'stores'" x-cloak class="space-y-4">
            <div class="hidden md:block admin-card overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Business</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Reason</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Reporter</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($storeReports as $report)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-navy-800 rounded-lg flex items-center justify-center text-white font-bold text-sm shrink-0">
                                        {{ substr($report->store->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[12px] font-bold text-navy-800 truncate">{{ $report->store->name }}</h4>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">{{ $report->store->user->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2 py-1 bg-rose-50 text-rose-600 text-[9px] font-bold uppercase rounded-lg">{{ $report->reason }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[11px] font-bold text-slate-600">{{ $report->user->name }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] text-slate-400 font-bold">{{ $report->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('admin.reports.show', ['type' => 'store', 'id' => $report->id]) }}" class="p-2 bg-slate-50 text-navy-800 hover:bg-gold-400 hover:text-white rounded-lg transition-all inline-block">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm font-medium">No store reports found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List (Card Design) -->
            <div class="md:hidden space-y-3">
                @forelse($storeReports as $report)
                <div class="admin-card p-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-12 h-12 bg-navy-800 rounded-lg flex items-center justify-center text-white font-bold text-sm shrink-0 border border-navy-900 shadow-sm">
                            {{ substr($report->store->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-[11px] font-bold text-navy-800 truncate mb-1">{{ $report->store->name }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="px-1.5 py-0.5 bg-rose-50 text-rose-500 text-[8px] font-bold uppercase rounded">{{ $report->reason }}</span>
                                <span class="text-[8px] text-slate-400 font-bold uppercase">{{ $report->created_at->format('M d') }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.show', ['type' => 'store', 'id' => $report->id]) }}" class="w-9 h-9 bg-slate-50 rounded-lg flex items-center justify-center text-navy-800 shrink-0">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest">No reports found.</div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $storeReports->appends(request()->query())->links('partials.pagination') }}
            </div>
        </div>
    </div>
</x-admin-layout>
