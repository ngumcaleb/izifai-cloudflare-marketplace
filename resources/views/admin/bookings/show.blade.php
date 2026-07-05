<x-admin-layout>
    <x-slot name="header">Booking Details</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-navy-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Bookings
        </a>

        <div class="admin-card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-bold text-navy-800">Booking #{{ $booking->id }}</h2>
                    <p class="text-xs text-slate-400">Created {{ $booking->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                    {{ $booking->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                    {{ $booking->status === 'confirmed' ? 'bg-blue-50 text-blue-600' : '' }}
                    {{ $booking->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}
                    {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}">
                    {{ $booking->status }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Customer</p>
                    <p class="text-sm font-bold text-navy-800">{{ $booking->user->name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Service</p>
                    <p class="text-sm font-bold text-navy-800">{{ $booking->service->name }}</p>
                    <p class="text-xs text-slate-500">{{ $booking->service->store->name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Booking Date</p>
                    <p class="text-sm font-bold text-navy-800">{{ $booking->booking_date->format('l, M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Price</p>
                    <p class="text-sm font-bold text-navy-800">XAF {{ number_format($booking->price ?? 0) }}</p>
                </div>
            </div>

            @if($booking->package)
            <div class="border-t border-slate-100 pt-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Package</p>
                <p class="text-sm font-bold text-navy-800">{{ $booking->package->name }}</p>
            </div>
            @endif

            @if($booking->notes)
            <div class="border-t border-slate-100 pt-4 mt-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Notes</p>
                <p class="text-sm text-slate-600">{{ $booking->notes }}</p>
            </div>
            @endif

            <div class="border-t border-slate-100 pt-6 mt-6">
                <h3 class="text-sm font-bold text-navy-800 mb-3">Update Status</h3>
                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <select name="status" class="flex-1 px-4 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold hover:bg-navy-900 transition-all">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
