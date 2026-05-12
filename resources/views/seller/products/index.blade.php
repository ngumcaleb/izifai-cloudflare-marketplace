<x-seller-layout>
    <x-slot name="title">All My Items</x-slot>

    <div class="space-y-4 md:space-y-6">
        <!-- Filter Bar -->
        <div class="bg-surface-container-lowest p-4 md:p-lg rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)]">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 md:gap-4">
                <div class="flex items-center bg-surface-container-low px-4 py-2 rounded-full w-full sm:w-auto sm:flex-1 md:w-96">
                    <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
                    <input type="text" placeholder="Search inventory..." class="bg-transparent border-none focus:ring-0 text-body-md w-full p-0 placeholder:text-on-surface-variant/50">
                </div>
                <a href="{{ route('seller.products.create') }}"
                   class="w-full sm:w-auto whitespace-nowrap flex items-center justify-center gap-2 bg-primary text-white px-5 md:px-6 py-2.5 rounded-full font-label-md md:font-label-lg hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-[18px] md:text-[20px]">add</span>
                    <span class="text-sm md:text-base">Post New Item</span>
                </a>
            </div>
        </div>

        <!-- Desktop Table (hidden on small screens) -->
        <div class="hidden md:block bg-surface-container-lowest rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)]">
            <table class="w-full text-left table-fixed">
                <colgroup>
                    <col class="w-[40%]">
                    <col class="w-[18%]">
                    <col class="w-[14%]">
                    <col class="w-[12%]">
                    <col class="w-[16%]">
                </colgroup>
                <thead class="bg-surface-container-low/50 border-b border-outline-variant/30">
                    <tr>
                        <th class="px-6 py-4 font-label-md text-on-surface-variant">Product Info</th>
                        <th class="px-6 py-4 font-label-md text-on-surface-variant">Pricing</th>
                        <th class="px-6 py-4 font-label-md text-on-surface-variant text-center">Status</th>
                        <th class="px-6 py-4 font-label-md text-on-surface-variant text-center">Stats</th>
                        <th class="px-6 py-4 font-label-md text-on-surface-variant text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($products as $product)
                        <tr class="hover:bg-surface-container-low/30 transition-all relative" x-data="{ open: false }">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-surface-container-high rounded-xl overflow-hidden shrink-0 shadow-sm">
                                        @if($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                                <span class="material-symbols-outlined">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 truncate">
                                        <h4 class="font-label-lg text-on-surface truncate leading-none mb-1" title="{{ $product->name }}">{{ $product->name }}</h4>
                                        <p class="text-label-sm text-on-surface-variant uppercase tracking-wider truncate">{{ $product->category->name ?? 'General' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-label-lg text-on-surface leading-none">{{ number_format($product->price) }} XAF</span>
                                    @if($product->old_price)
                                        <span class="text-label-sm text-on-surface-variant/60 line-through mt-1">{{ number_format($product->old_price) }} XAF</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $product->stock_status === 'in_stock' ? 'bg-primary/10 text-primary' : 'bg-error-container text-error' }}">
                                    <span class="material-symbols-outlined text-[12px]">{{ $product->stock_status === 'in_stock' ? 'check_circle' : 'cancel' }}</span>
                                    {{ str_replace('_', ' ', $product->stock_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    <span class="text-label-sm font-bold">{{ $product->views }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center relative">
                                <button @click="open = !open" @click.outside="open = false"
                                        class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                                <div x-show="open" x-cloak
                                     @click.outside="open = false"
                                     class="absolute right-4 top-12 w-44 bg-surface rounded-2xl shadow-[0px_8px_30px_rgba(0,0,0,0.12)] border border-outline-variant/20 z-50 overflow-hidden"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95">
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                                       class="flex items-center gap-3 px-4 py-3 text-body-md text-on-surface-variant hover:bg-surface-container-low transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                        View Public Page
                                    </a>
                                    <a href="{{ route('seller.products.edit', $product->id) }}"
                                       class="flex items-center gap-3 px-4 py-3 text-body-md text-on-surface-variant hover:bg-surface-container-low transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        Edit Listing
                                    </a>
                                    <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this listing?')">
                                        @csrf @method('DELETE')
                                        <button class="w-full flex items-center gap-3 px-4 py-3 text-body-md text-error hover:bg-error-container/30 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                            Delete Listing
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <span class="material-symbols-outlined text-5xl text-on-surface-variant/30">inventory_2</span>
                                <p class="text-headline-md text-on-surface-variant mt-4">No items found in your inventory</p>
                                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center gap-2 mt-4 bg-primary text-white px-6 py-2.5 rounded-full font-label-lg hover:opacity-90 transition-opacity">
                                    <span class="material-symbols-outlined text-[20px]">add</span>
                                    Start Listing
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards (shown on small screens) -->
        <div class="md:hidden space-y-3">
            @forelse($products as $product)
                <div class="bg-surface-container-lowest rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] p-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 bg-surface-container-high rounded-xl overflow-hidden shrink-0 shadow-sm">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                    <span class="material-symbols-outlined">image</span>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-label-lg text-on-surface truncate leading-tight mb-0.5">{{ $product->name }}</h4>
                            <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">{{ $product->category->name ?? 'General' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-label-lg text-on-surface leading-none">{{ number_format($product->price) }} XAF</span>
                            @if($product->old_price)
                                <span class="text-label-sm text-on-surface-variant/60 line-through mt-0.5">{{ number_format($product->old_price) }} XAF</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $product->stock_status === 'in_stock' ? 'bg-primary/10 text-primary' : 'bg-error-container text-error' }}">
                                <span class="material-symbols-outlined text-[10px]">{{ $product->stock_status === 'in_stock' ? 'check_circle' : 'cancel' }}</span>
                                {{ str_replace('_', ' ', $product->stock_status) }}
                            </span>
                            <div class="flex items-center gap-1 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                <span class="text-label-sm font-bold">{{ $product->views }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-2 border-t border-outline-variant/20">
                        <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                           class="flex-1 flex items-center justify-center gap-1.5 py-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-xl transition-all text-label-md">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            View
                        </a>
                        <a href="{{ route('seller.products.edit', $product->id) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 py-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-xl transition-all text-label-md">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            Edit
                        </a>
                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this listing?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full flex items-center justify-center gap-1.5 py-2 text-error hover:bg-error-container rounded-xl transition-all text-label-md">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-surface-container-lowest rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">inventory_2</span>
                    <p class="text-headline-md text-on-surface-variant mt-3">No items found</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center gap-2 mt-3 bg-primary text-white px-5 py-2.5 rounded-full font-label-md hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Start Listing
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-seller-layout>
