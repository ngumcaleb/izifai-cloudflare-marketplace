<x-admin-layout>
    <x-slot name="header">Promotion Management</x-slot>

    <!-- Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/shiny-black-headphones-reflect-music-technology-generated-by-ai_188544-24151.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-10 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Promotion <span class="text-gold-400">Control</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Review, approve or manage premium visibility requests from our merchants.
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-navy-900 border border-gold-500/30 text-white p-3 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
        <span class="text-xs font-bold uppercase tracking-wider">{{ session('success') }}</span>
    </div>
    @endif

    <div class="space-y-6">
        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.ads.index') }}" 
               class="px-4 py-2 {{ !request('status') ? 'bg-navy-800 text-white shadow-md' : 'bg-white text-slate-500 border border-slate-100 hover:border-slate-300' }} rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
               All <span class="hidden sm:inline">Requests</span>
            </a>
            <a href="{{ route('admin.ads.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 {{ request('status') == 'pending' ? 'bg-navy-800 text-white shadow-md' : 'bg-white text-slate-500 border border-slate-100 hover:border-slate-300' }} rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
               Pending
            </a>
            <a href="{{ route('admin.ads.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 {{ request('status') == 'approved' ? 'bg-navy-800 text-white shadow-md' : 'bg-white text-slate-500 border border-slate-100 hover:border-slate-300' }} rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
               Active
            </a>
        </div>

        <!-- Search & Filter Bar -->
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.ads.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by title or store..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select name="store_id" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Stores</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                            @endforeach
                        </select>
                        <select name="promotable_type" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Types</option>
                            <option value="App\Models\Product" {{ request('promotable_type') == "App\Models\Product" ? 'selected' : '' }}>Product</option>
                            <option value="App\Models\Service" {{ request('promotable_type') == "App\Models\Service" ? 'selected' : '' }}>Service</option>
                            <option value="App\Models\Store" {{ request('promotable_type') == "App\Models\Store" ? 'selected' : '' }}>Store</option>
                        </select>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <select name="per_page" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">Filter</button>
                        @if(request()->anyFilled(['search', 'store_id', 'promotable_type', 'date_from', 'date_to', 'per_page']))
                            <a href="{{ route('admin.ads.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="admin-card overflow-hidden">
            <div class="hidden md:block">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-50">
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Promotion</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Merchant</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Plan</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($requests as $ad)
                        <tr class="hover:bg-slate-50/20 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="min-w-0">
                                        <h4 class="text-[12px] font-bold text-navy-800 truncate group-hover:text-emerald-600 transition-colors">{{ $ad->title }}</h4>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[9px] font-bold text-slate-400 uppercase">{{ class_basename($ad->promotable_type ?? 'custom') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-bold text-navy-800 leading-none">{{ $ad->store->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex flex-col items-center px-3 py-1 bg-slate-50 rounded-lg border border-slate-100">
                                    <span class="text-[10px] font-bold text-navy-800">{{ $ad->days }} Days</span>
                                    <span class="text-[9px] font-bold text-emerald-600">XAF {{ number_format($ad->total_amount ?? 0) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($ad->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 bg-amber-50 text-amber-600 text-[8px] font-bold uppercase rounded-full border border-amber-100">Pending</span>
                                @elseif($ad->status === 'approved')
                                    <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-bold uppercase rounded-full border border-emerald-100">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 bg-rose-50 text-rose-600 text-[8px] font-bold uppercase rounded-full border border-rose-100">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.ads.show', $ad) }}" 
                                       class="p-2 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all"
                                       title="View Details">
                                        <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                    </a>
                                    <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST" onsubmit="return confirm('Delete this ad request permanently?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm">No promotion requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List -->
            <div class="md:hidden divide-y divide-slate-50">
                @forelse($requests as $ad)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="min-w-0">
                            <h4 class="text-xs font-bold text-navy-800 truncate">{{ $ad->title }}</h4>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-[9px] font-bold text-emerald-600">XAF {{ number_format($ad->total_amount ?? 0) }}</span>
                                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-widest">• {{ $ad->days }}d</span>
                                @if($ad->status === 'pending')
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                @elseif($ad->status === 'approved')
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.ads.show', $ad) }}" class="p-2 text-slate-300 group-hover:text-navy-800 transition-colors">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </a>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No promotion requests found.</div>
                @endforelse
            </div>
        </div>

        @if($requests->hasPages())
        <div class="mt-4">
            {{ $requests->links('partials.pagination') }}
        </div>
        @endif
    </div>
</x-admin-layout>
