<x-app-layout>
    <x-slot name="sidebar">
        <!-- Seller Sidebar (Compact) -->
        <aside class="w-[240px] bg-[#0A1D37] text-white flex flex-col min-h-screen sticky top-0">
            <div class="p-6 h-20 flex items-center gap-3 border-b border-white/10 shrink-0">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center font-black text-sm">S</div>
                <span class="font-black text-xs uppercase tracking-widest">Seller Dashboard</span>
            </div>

            <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                <a href="{{ route('seller.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-white/5 text-slate-400 hover:text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span>Overview</span>
                </a>
                <a href="{{ route('seller.products.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-green-600 text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Product Catalog</span>
                </a>
                <a href="{{ route('seller.store.settings') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-white/5 text-slate-400 hover:text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Store Profile</span>
                </a>
            </nav>
        </aside>
    </x-slot>

    <div class="p-6 md:p-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-xl font-black text-slate-900 mb-1 tracking-tight">Product Catalog</h1>
                <p class="text-[11px] text-slate-500 font-medium">List and manage your commercial products.</p>
            </div>
            <a href="{{ route('seller.products.create') }}"
                class="bg-[#16A34A] text-white px-6 py-2.5 rounded-lg font-bold text-[11px] uppercase tracking-widest hover:bg-green-700 shadow-xl shadow-green-600/10 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Post New Item
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead
                        class="bg-slate-50 text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                        <tr>
                            <th class="px-6 py-4">Product Details</th>
                            <th class="px-6 py-4 text-center">Category</th>
                            <th class="px-6 py-4 text-center">Price</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-12 h-12 rounded bg-slate-100 overflow-hidden border border-slate-50 shrink-0 p-1">
                                            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="max-w-[200px]">
                                            <p class="font-bold text-slate-800 text-xs line-clamp-1">{{ $product->name }}
                                            </p>
                                            <p
                                                class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter mt-0.5">
                                                SKU: IZ-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="text-[9px] font-black bg-slate-100 text-slate-500 px-2.5 py-1 rounded-full uppercase tracking-tighter">{{ $product->category->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-center font-black text-slate-900 text-xs">
                                    {{ number_format($product->price) }} XAF</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1 text-[8px] font-black text-green-600 bg-green-50 px-2.5 py-1 rounded-full uppercase tracking-widest">
                                        <div class="w-1 h-1 bg-green-600 rounded-full"></div>
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('seller.products.edit', $product->id) }}"
                                            class="p-2 text-slate-400 hover:text-green-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <button class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="font-black text-slate-400 uppercase tracking-widest text-[10px]">Your
                                            catalog is empty</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>