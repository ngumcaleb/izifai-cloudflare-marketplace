<x-admin-layout>
    <x-slot name="header">Merchant Directory</x-slot>

    <!-- Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/smiling-businesspeople-working-office_23-2148908914.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Merchant <span class="text-gold-400">Directory</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Verify new sellers, manage trust badges, and monitor business activity.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Search & Filters -->
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.stores.index') }}" method="GET" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search stores, owners, or emails..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">
                        Find Merchant
                    </button>
                    @if(request()->anyFilled(['search', 'location', 'status', 'badge', 'is_featured', 'date_from', 'date_to', 'per_page']))
                    <a href="{{ route('admin.stores.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center gap-2">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        Clear
                    </a>
                    @endif
                </div>
                <div class="flex flex-wrap gap-3">
                    <select name="location" class="flex-1 min-w-[140px] px-3.5 py-2 bg-slate-50 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                        <option value="{{ $loc }}" {{ request('location') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="flex-1 min-w-[120px] px-3.5 py-2 bg-slate-50 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <option value="">All Status</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    <select name="badge" class="flex-1 min-w-[140px] px-3.5 py-2 bg-slate-50 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <option value="">All Badges</option>
                        <option value="Verified Seller" {{ request('badge') === 'Verified Seller' ? 'selected' : '' }}>Verified Seller</option>
                        <option value="Trusted Store" {{ request('badge') === 'Trusted Store' ? 'selected' : '' }}>Trusted Store</option>
                        <option value="Premium Seller" {{ request('badge') === 'Premium Seller' ? 'selected' : '' }}>Premium Seller</option>
                        <option value="Legit Business" {{ request('badge') === 'Legit Business' ? 'selected' : '' }}>Legit Business</option>
                        <option value="Top Rated" {{ request('badge') === 'Top Rated' ? 'selected' : '' }}>Top Rated</option>
                    </select>
                    <select name="is_featured" class="flex-1 min-w-[120px] px-3.5 py-2 bg-slate-50 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <option value="">Featured: All</option>
                        <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                        <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Regular</option>
                    </select>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="From" class="flex-1 min-w-[130px] px-3.5 py-2 bg-slate-50 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="To" class="flex-1 min-w-[130px] px-3.5 py-2 bg-slate-50 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                    <select name="per_page" class="flex-1 min-w-[100px] px-3.5 py-2 bg-slate-50 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page') == '15' ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </form>
        </div>

        @if(session('success'))
        <div class="bg-navy-900 border border-gold-500/30 text-white p-3 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
            <span class="text-xs font-bold uppercase tracking-wider">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Merchants List -->
        <div class="admin-card overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Business</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Owner</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($stores as $store)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0">
                                        @if($store->logo)
                                            <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
                                        @else
                                            <x-store-default-logo :store="$store" size="sm" />
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-[13px] font-bold text-navy-800">{{ $store->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-medium">Joined {{ $store->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-bold text-navy-800 leading-none">{{ $store->user->name }}</span>
                                    <span class="text-[10px] text-slate-500 font-medium mt-1">{{ $store->user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-wrap gap-2">
                                    @if($store->is_verified)
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-bold uppercase rounded">Verified</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[8px] font-bold uppercase rounded">Pending</span>
                                    @endif
                                    @if($store->badge)
                                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[8px] font-bold uppercase rounded">{{ $store->badge }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.stores.show', $store) }}" class="px-4 py-2 bg-slate-50 text-navy-800 hover:bg-gold-400 hover:text-white rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Manage</a>
                                    <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" onsubmit="return confirm('Permanently delete this business?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all" title="Delete Business">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center text-slate-400 italic text-sm">No merchants found matching your criteria.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List (Cards) -->
            <div class="md:hidden divide-y divide-slate-50">
                @forelse($stores as $store)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                            @if($store->logo)
                                <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
                            @else
                                <x-store-default-logo :store="$store" size="md" />
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-navy-800 truncate">{{ $store->name }}</h4>
                            <p class="text-[10px] text-slate-500 truncate">{{ $store->user->name }}</p>
                            <div class="flex gap-1.5 mt-1">
                                <span class="px-1.5 py-0.5 {{ $store->is_verified ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} text-[7px] font-bold uppercase rounded">
                                    {{ $store->is_verified ? 'Verified' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.stores.show', $store) }}" class="p-2 bg-slate-50 text-navy-800 rounded-lg shrink-0">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No merchants found.</div>
                @endforelse
            </div>
        </div>

        @if($stores->hasPages())
        <div class="mt-4">
            {{ $stores->links('partials.pagination') }}
        </div>
        @endif
    </div>
</x-admin-layout>
