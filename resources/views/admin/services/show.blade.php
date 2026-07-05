<x-admin-layout>
    <x-slot name="header">Service Details</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-navy-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Services
        </a>

        <div class="admin-card overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-64 h-64 bg-slate-100 rounded-xl overflow-hidden shrink-0">
                        @if($service->mainImage)
                            <img src="{{ $service->mainImage->url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i data-lucide="handyman" class="w-12 h-12"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 space-y-4">
                        <div>
                            <h1 class="text-xl font-bold text-navy-800">{{ $service->name }}</h1>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ ($service->approval_status ?? 'pending') === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ ucfirst($service->approval_status ?? 'pending') }}
                            </span>
                            @if($service->is_featured)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-600">Featured</span>
                            @endif
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Starting Price</p>
                                <p class="text-lg font-bold text-navy-800">XAF {{ number_format($service->starting_price) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Seller</p>
                                <p class="text-sm font-bold text-navy-800">{{ $service->store->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Delivery</p>
                                <p class="text-sm font-bold text-navy-800">{{ $service->delivery_time ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if($service->description)
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Description</p>
                                <p class="text-sm text-slate-600">{{ $service->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            @if(($service->approval_status ?? 'pending') !== 'approved')
                <form action="{{ route('admin.services.approve', $service) }}" method="POST">
                    @csrf
                    <button class="px-6 py-2.5 bg-emerald-500 text-white rounded-lg text-xs font-bold hover:bg-emerald-600 transition-all">Approve Listing</button>
                </form>
            @endif
            <form action="{{ route('admin.services.feature', $service) }}" method="POST">
                @csrf
                <button class="px-6 py-2.5 {{ $service->is_featured ? 'bg-purple-500' : 'bg-navy-800' }} text-white rounded-lg text-xs font-bold hover:opacity-90 transition-all">
                    {{ $service->is_featured ? 'Remove Featured' : 'Mark as Featured' }}
                </button>
            </form>
            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="px-6 py-2.5 bg-slate-100 text-navy-800 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">View on Site</a>
            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service permanently?')">
                @csrf
                @method('DELETE')
                <button class="px-6 py-2.5 bg-rose-500 text-white rounded-lg text-xs font-bold hover:bg-rose-600 transition-all">Delete</button>
            </form>
        </div>

        @if($service->packages->count() > 0)
            <div class="admin-card p-6">
                <h3 class="text-sm font-bold text-navy-800 mb-4">Packages ({{ $service->packages->count() }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach($service->packages as $package)
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <h4 class="text-xs font-bold text-navy-800">{{ $package->name }}</h4>
                            <p class="text-lg font-bold text-navy-800 mt-1">XAF {{ number_format($package->price) }}</p>
                            <p class="text-[10px] text-slate-500">Delivery: {{ $package->delivery_time ?? 'N/A' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($service->bookings->count() > 0)
            <div class="admin-card p-6">
                <h3 class="text-sm font-bold text-navy-800 mb-4">Bookings ({{ $service->bookings->count() }})</h3>
                <div class="space-y-2">
                    @foreach($service->bookings as $booking)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <div>
                                <p class="text-xs font-bold text-navy-800">{{ $booking->user->name }}</p>
                                <p class="text-[10px] text-slate-500">{{ $booking->booking_date->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600' : ($booking->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500') }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
