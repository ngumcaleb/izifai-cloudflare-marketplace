<x-seller-layout>
    <x-slot name="title">My Rentals</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">My Rentals</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $rentals->count() }} rental(s)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seller.rentals.create') }}"
                   class="whitespace-nowrap flex items-center justify-center gap-1.5 bg-primary text-white px-4 py-2 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                    <i class="fa-solid fa-plus text-[18px]"></i>
                    <span>Add Rental</span>
                </a>
            </div>
        </div>

        <!-- Rentals List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 divide-y divide-gray-50">
            @forelse($rentals as $rental)
                <div class="px-5 py-3.5 flex items-center gap-4 hover:bg-gray-50/50 transition-all relative" x-data="{ open: false }">
                    <div class="flex-1 min-w-0 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if($rental->main_image_url)
                                <img src="{{ $rental->main_image_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="fa-solid fa-image text-[18px]"></i>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 truncate leading-tight mb-0.5" title="{{ $rental->name }}">{{ $rental->name }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">{{ $rental->category->name ?? 'General' }}</span>
                                <span class="text-[11px] text-gray-300">•</span>
                                <span class="text-[11px] font-bold text-gray-800">{{ number_format($rental->rate) }} XAF/{{ $rental->billing_unit }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-20 text-center shrink-0">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                            {{ $rental->status === 'published' ? 'bg-primary/5 text-primary' : ($rental->status === 'draft' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                            <i class="fa-solid text-[10px] {{ $rental->status === 'published' ? 'fa-circle-check text-green-500' : ($rental->status === 'draft' ? 'fa-pen text-amber-500' : 'fa-box-archive text-gray-400') }}"></i>
                            {{ ucfirst($rental->status) }}
                        </span>
                    </div>
                    <div class="w-10 text-center shrink-0 relative">
                        <button @click="open = !open" @click.outside="open = false"
                                class="p-1.5 text-gray-400 hover:text-primary hover:bg-gray-50 rounded-lg transition-all">
                            <i class="fa-solid fa-ellipsis-vertical text-[18px]"></i>
                        </button>
                        <div x-show="open" x-cloak
                             @click.outside="open = false"
                             class="absolute right-0 top-9 w-44 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95">
                            <a href="{{ route('rentals.show', $rental->slug) }}" target="_blank"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-up-right-from-square text-[18px]"></i>
                                View Public Page
                            </a>
                            <a href="{{ route('seller.rentals.edit', $rental->id) }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-pen text-[18px]"></i>
                                Edit Listing
                            </a>
                            <form action="{{ route('seller.rentals.destroy', $rental->id) }}" method="POST" onsubmit="return confirm('Delete this rental item?')">
                                @csrf @method('DELETE')
                                <button class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fa-solid fa-trash text-[18px]"></i>
                                    Delete Listing
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-warehouse text-3xl text-gray-300"></i>
                    </div>
                    <p class="text-base font-bold text-gray-900">No rentals yet</p>
                    <p class="text-sm text-gray-500 mt-1">Add your first rental to start earning on the marketplace.</p>
                    <a href="{{ route('seller.rentals.create') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                        <i class="fa-solid fa-plus text-[18px]"></i>
                        Add Rental
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-seller-layout>