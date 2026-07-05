<x-admin-layout>
    <x-slot name="header">Rental Items</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/modern-equipped-apartment_23-2147938218.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Rental <span class="text-gold-400">Inventory</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Monitor all rental listings and manage their availability status.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.rentals.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search rentals or sellers..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select name="category_id" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <select name="store_id" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Stores</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                            @endforeach
                        </select>
                        <select name="is_featured" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">Featured: All</option>
                            <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                            <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Regular</option>
                        </select>
                        <select name="billing_unit" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">Billing: All</option>
                            <option value="day" {{ request('billing_unit') == 'day' ? 'selected' : '' }}>Day</option>
                            <option value="week" {{ request('billing_unit') == 'week' ? 'selected' : '' }}>Week</option>
                            <option value="month" {{ request('billing_unit') == 'month' ? 'selected' : '' }}>Month</option>
                        </select>
                        <select name="status" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <select name="per_page" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">Filter</button>
                        @if(request()->anyFilled(['search', 'category_id', 'store_id', 'is_featured', 'billing_unit', 'status', 'per_page']))
                            <a href="{{ route('admin.rentals.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="admin-card overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Item</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Seller</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Rate</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($rentals as $rental)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden shrink-0 border border-slate-50 shadow-sm">
                                        @if($rental->main_image_url)
                                            <img src="{{ $rental->main_image_url }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i data-lucide="shelves" class="w-5 h-5"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[13px] font-bold text-navy-800 truncate">{{ $rental->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-medium truncate">{{ $rental->category->name ?? 'Rental' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-[12px] font-medium text-slate-600">{{ $rental->store->name }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-navy-800">XAF {{ number_format($rental->rate) }}/{{ $rental->billing_unit ?? 'day' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 {{ $rental->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }} text-[8px] font-bold uppercase rounded">
                                    {{ $rental->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.rentals.show', $rental) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all inline-flex" title="View details">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.rentals.destroy', $rental) }}" method="POST" onsubmit="return confirm('Delete this rental item permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm">No rental items found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-slate-50">
                @forelse($rentals as $rental)
                <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition-colors">
                    <div class="w-16 h-16 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-50 shadow-sm">
                        @if($rental->main_image_url)
                            <img src="{{ $rental->main_image_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i data-lucide="shelves" class="w-6 h-6"></i>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between">
                            <h4 class="text-[13px] font-bold text-navy-800 truncate">{{ $rental->name }}</h4>
                            <span class="text-[10px] font-bold text-navy-800 whitespace-nowrap ml-2">XAF {{ number_format($rental->rate) }}</span>
                        </div>
                        <p class="text-[10px] text-slate-500 truncate mt-0.5">{{ $rental->store->name }}</p>
                        <span class="px-1.5 py-0.5 {{ $rental->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }} text-[7px] font-bold uppercase rounded mt-1.5 inline-block">
                            {{ $rental->status }}
                        </span>
                    </div>
                    <a href="{{ route('admin.rentals.show', $rental) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 rounded-lg transition-all inline-flex">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No rental items found.</div>
                @endforelse
            </div>
        </div>

        @if($rentals->hasPages())
            <div>{{ $rentals->links('partials.pagination') }}</div>
        @endif
    </div>
</x-admin-layout>
