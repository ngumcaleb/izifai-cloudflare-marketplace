<x-admin-layout>
    <x-slot name="header">Service Bookings</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Service <span class="text-gold-400">Bookings</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Monitor and manage all service booking requests across the platform.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by customer or service..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select name="service_id" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Services</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <select name="store_id" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Stores</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                            @endforeach
                        </select>
                        <select name="status" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                        @if(request()->anyFilled(['search', 'service_id', 'store_id', 'status', 'date_from', 'date_to', 'per_page']))
                            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
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
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Service</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-navy-800 shrink-0">
                                        {{ substr($booking->user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[12px] font-bold text-navy-800 truncate">{{ $booking->user->name }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-[12px] font-medium text-slate-600">{{ $booking->service->name }}</td>
                            <td class="px-6 py-4 text-[11px] text-slate-500">{{ $booking->booking_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase
                                    {{ $booking->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                    {{ $booking->status === 'confirmed' ? 'bg-blue-50 text-blue-600' : '' }}
                                    {{ $booking->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}
                                    {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all inline-flex">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm">No bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-slate-50">
                @forelse($bookings as $booking)
                <a href="{{ route('admin.bookings.show', $booking) }}" class="p-4 flex items-center gap-4 hover:bg-slate-50 transition-colors block">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between">
                            <span class="text-[13px] font-bold text-navy-800">{{ $booking->user->name }}</span>
                            <span class="text-[10px] text-slate-500">{{ $booking->booking_date->format('M d') }}</span>
                        </div>
                        <p class="text-[10px] text-slate-500">{{ $booking->service->name }}</p>
                        <span class="px-1.5 py-0.5 rounded text-[7px] font-bold uppercase mt-1 inline-block
                            {{ $booking->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                            {{ $booking->status === 'confirmed' ? 'bg-blue-50 text-blue-600' : '' }}
                            {{ $booking->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}
                            {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}">
                            {{ $booking->status }}
                        </span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 shrink-0"></i>
                </a>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No bookings found.</div>
                @endforelse
            </div>
        </div>

        @if($bookings->hasPages())
            <div>{{ $bookings->links('partials.pagination') }}</div>
        @endif
    </div>
</x-admin-layout>
