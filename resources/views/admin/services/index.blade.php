<x-admin-layout>
    <x-slot name="header">Service Listings</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/medium-shot-people-working-together_23-2149301621.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Service <span class="text-gold-400">Listings</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Manage all service offerings, approve pending listings, and feature top services.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.services.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search services or sellers..."
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
                        <select name="status" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        </select>
                        <select name="per_page" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">Filter</button>
                        @if(request()->anyFilled(['search', 'category_id', 'store_id', 'is_featured', 'status', 'per_page']))
                            <a href="{{ route('admin.services.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
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
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Service</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Seller</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Price</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($services as $service)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden shrink-0 border border-slate-50 shadow-sm">
                                        @if($service->mainImage)
                                            <img src="{{ $service->mainImage->url }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i data-lucide="handyman" class="w-5 h-5"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[13px] font-bold text-navy-800 truncate">{{ $service->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-medium truncate">{{ $service->category->name ?? 'Service' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-[12px] font-medium text-slate-600">{{ $service->store->name }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-navy-800">XAF {{ number_format($service->starting_price) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    @if($service->is_featured)
                                        <span class="inline-flex w-fit px-2 py-0.5 bg-purple-50 text-purple-600 text-[8px] font-bold uppercase rounded">Featured</span>
                                    @endif
                                    <span class="inline-flex w-fit px-2 py-0.5 {{ ($service->approval_status ?? 'pending') === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} text-[8px] font-bold uppercase rounded">
                                        {{ ucfirst($service->approval_status ?? 'pending') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.services.show', $service) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all inline-flex" title="View details">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all inline-flex" title="View on site">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service permanently?')">
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
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm">No services found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-slate-50">
                @forelse($services as $service)
                <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition-colors">
                    <div class="w-16 h-16 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-50 shadow-sm">
                        @if($service->mainImage)
                            <img src="{{ $service->mainImage->url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i data-lucide="handyman" class="w-6 h-6"></i>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between">
                            <h4 class="text-[13px] font-bold text-navy-800 truncate leading-tight">{{ $service->name }}</h4>
                            <span class="text-[10px] font-bold text-navy-800 whitespace-nowrap ml-2">XAF {{ number_format($service->starting_price) }}</span>
                        </div>
                        <p class="text-[10px] text-slate-500 truncate mt-0.5">{{ $service->store->name }}</p>
                        <div class="flex gap-1.5 mt-1.5">
                            @if($service->is_featured)
                                <span class="px-1.5 py-0.5 bg-purple-50 text-purple-600 text-[7px] font-bold uppercase rounded">Featured</span>
                            @endif
                            <span class="px-1.5 py-0.5 {{ ($service->approval_status ?? 'pending') === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} text-[7px] font-bold uppercase rounded">
                                {{ ucfirst($service->approval_status ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('admin.services.show', $service) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 rounded-lg transition-all inline-flex">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No services found.</div>
                @endforelse
            </div>
        </div>

        @if($services->hasPages())
            <div>{{ $services->links('partials.pagination') }}</div>
        @endif
    </div>
</x-admin-layout>
