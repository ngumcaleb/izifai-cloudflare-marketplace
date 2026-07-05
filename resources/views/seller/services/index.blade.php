<x-seller-layout>
    <x-slot name="title">My Services</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">My Services</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage your service listings</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seller.services.create') }}"
                   class="whitespace-nowrap flex items-center justify-center gap-1.5 bg-primary text-white px-4 py-2 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>New Service</span>
                </a>
            </div>
        </div>

        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100/80 divide-y divide-gray-50">
            <div class="px-5 py-3.5 flex items-center gap-4 bg-gray-50/80 border-b border-gray-100">
                <div class="flex-1 min-w-0 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Service</div>
                <div class="w-20 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</div>
                <div class="w-24 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Views</div>
                <div class="w-10"></div>
            </div>
            @forelse($services as $service)
                <div class="px-5 py-3.5 flex items-center gap-4 hover:bg-gray-50/50 transition-all relative" x-data="{ open: false }">
                    <div class="flex-1 min-w-0 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if($service->main_image_url)
                                <img src="{{ $service->main_image_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <span class="material-symbols-outlined text-[18px]">image</span>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 truncate leading-tight mb-0.5" title="{{ $service->name }}">{{ $service->name }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">{{ $service->category->name ?? 'General' }}</span>
                                <span class="text-[11px] text-gray-300">•</span>
                                <span class="text-[11px] font-bold text-gray-800">From {{ number_format($service->starting_price) }} XAF</span>
                                @if($service->packages->count() > 0)
                                    <span class="text-[10px] text-gray-400">{{ $service->packages->count() }} package{{ $service->packages->count() > 1 ? 's' : '' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="w-20 text-center shrink-0">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $service->status === 'active' ? 'bg-primary/5 text-primary' : 'bg-red-50 text-red-600' }}">
                            <span class="material-symbols-outlined text-[10px]">{{ $service->status === 'active' ? 'check_circle' : 'cancel' }}</span>
                            {{ $service->status === 'active' ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="w-24 text-center shrink-0">
                        <div class="flex items-center justify-center gap-1 text-gray-400">
                            <span class="material-symbols-outlined text-[14px]">visibility</span>
                            <span class="text-xs font-bold">{{ $service->views }}</span>
                        </div>
                    </div>
                    <div class="w-10 text-center shrink-0 relative">
                        <button @click="open = !open" @click.outside="open = false"
                                class="p-1.5 text-gray-400 hover:text-primary hover:bg-gray-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
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
                            <a href="{{ route('services.show', $service->slug) }}" target="_blank"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                View Public Page
                            </a>
                            <a href="{{ route('seller.services.edit', $service->id) }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                Edit Listing
                            </a>
                            <form action="{{ route('seller.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                @csrf @method('DELETE')
                                <button class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                    Delete Listing
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-3xl text-gray-300">handyman</span>
                    </div>
                    <p class="text-base font-bold text-gray-900">No services found</p>
                    <p class="text-sm text-gray-500 mt-1">Start by adding your first service to the marketplace.</p>
                    <a href="{{ route('seller.services.create') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Start Listing
                    </a>
                </div>
            @endforelse
        </div>

        <div class="md:hidden space-y-3">
            @forelse($services as $service)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                            @if($service->main_image_url)
                                <img src="{{ $service->main_image_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <span class="material-symbols-outlined">image</span>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-sm font-bold text-gray-900 truncate leading-tight mb-0.5">{{ $service->name }}</h4>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">{{ $service->category->name ?? 'General' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900 leading-none">From {{ number_format($service->starting_price) }} XAF</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $service->status === 'active' ? 'bg-primary/5 text-primary' : 'bg-red-50 text-red-600' }}">
                                <span class="material-symbols-outlined text-[10px]">{{ $service->status === 'active' ? 'check_circle' : 'cancel' }}</span>
                                {{ $service->status }}
                            </span>
                            <div class="flex items-center gap-1 text-gray-400">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                <span class="text-xs font-bold">{{ $service->views }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                        <a href="{{ route('services.show', $service->slug) }}" target="_blank"
                           class="flex-1 flex items-center justify-center gap-1.5 py-2 text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition-all text-xs font-semibold">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            View
                        </a>
                        <a href="{{ route('seller.services.edit', $service->id) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 py-2 text-gray-500 hover:text-primary hover:bg-gray-50 rounded-xl transition-all text-xs font-semibold">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            Edit
                        </a>
                        <form action="{{ route('seller.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Delete this service?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full flex items-center justify-center gap-1.5 py-2 text-red-600 hover:bg-red-50 rounded-xl transition-all text-xs font-semibold">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-8 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-3xl text-gray-300">handyman</span>
                    </div>
                    <p class="text-base font-bold text-gray-900">No services found</p>
                    <p class="text-sm text-gray-500 mt-1">Start adding services to your store.</p>
                    <a href="{{ route('seller.services.create') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Start Listing
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-seller-layout>
