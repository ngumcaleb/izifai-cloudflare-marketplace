<x-seller-layout>
    <x-slot name="title">My Products</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in"
         x-data="{ showCreateCollection: false, newName: '' }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                @if($currentCollection)
                    <div class="flex items-center gap-3">
                        <a href="{{ route('seller.products.index') }}"
                           class="p-1.5 -ml-1.5 text-gray-400 hover:text-primary hover:bg-gray-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        </a>
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold text-gray-900">{{ $currentCollection->name }}</h1>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $products->count() }} product(s)</p>
                        </div>
                    </div>
                @else
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">My Products</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Organized by collections</p>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seller.products.create', $currentCollection ? ['collection' => $currentCollection->id] : []) }}"
                   class="whitespace-nowrap flex items-center justify-center gap-1.5 bg-primary text-white px-4 py-2 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Add Product</span>
                </a>
                @unless($currentCollection)
                    <button @click="showCreateCollection = !showCreateCollection"
                            class="whitespace-nowrap flex items-center justify-center gap-1.5 border border-dashed border-gray-300 text-gray-500 px-4 py-2 rounded-xl text-sm font-bold hover:border-primary hover:text-primary hover:bg-primary/5 active:scale-[0.97] transition-all">
                        <span class="material-symbols-outlined text-[18px]">create_new_folder</span>
                        <span class="hidden sm:inline">Create Collection</span>
                        <span class="sm:hidden">Collection</span>
                    </button>
                @endunless
            </div>
        </div>

        <!-- Create Collection Inline -->
        <div x-show="showCreateCollection" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-primary/5 border border-primary/20 rounded-2xl p-4">
            <form action="{{ route('seller.store-categories.store') }}" method="POST" class="flex items-center gap-3">
                @csrf
                <input type="hidden" name="type" value="product">
                <input type="text" name="name" x-model="newName" required placeholder="Collection name..."
                       class="flex-1 h-10 bg-white border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                <button type="submit"
                        class="h-10 px-5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    Create
                </button>
                <button type="button" @click="showCreateCollection = false; newName = ''"
                        class="h-10 px-4 bg-white border border-gray-200 text-gray-500 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all">
                    Cancel
                </button>
            </form>
        </div>

        @if($currentCollection)
            <!-- Products in Collection -->
            @include('seller.products._list', ['products' => $products])
        @else
            <!-- Collections View -->
            <div class="space-y-6">
                @if($storeCategories->isNotEmpty())
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-1">Collections</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3">
                            @foreach($storeCategories as $cat)
                                <div class="relative" x-data="{ open: false, rename: false, newName: '{{ $cat->name }}' }">
                                    <template x-if="!rename">
                                        <div>
                                            <a href="{{ route('seller.products.index', ['collection' => $cat->id]) }}"
                                               class="group bg-white rounded-2xl border border-gray-100/80 shadow-sm p-5 text-center hover:border-primary/30 hover:shadow-md active:scale-[0.97] transition-all block">
                                                <div class="w-14 h-14 rounded-2xl bg-primary/5 text-primary flex items-center justify-center mx-auto mb-3 group-hover:bg-primary group-hover:text-white transition-all">
                                                    <span class="material-symbols-outlined text-2xl">folder</span>
                                                </div>
                                                <h3 class="text-sm font-bold text-gray-900 truncate group-hover:text-primary transition-colors">{{ $cat->name }}</h3>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $cat->products_count }} product(s)</p>
                                            </a>
                                            <button @click.stop="open = !open"
                                                    class="absolute top-2 right-2 p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                                <span class="material-symbols-outlined text-[16px]">more_vert</span>
                                            </button>
                                            <div x-show="open" x-cloak @click.outside="open = false"
                                                 class="absolute right-0 top-10 w-40 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="opacity-0 scale-95"
                                                 x-transition:enter-end="opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="opacity-100 scale-100"
                                                 x-transition:leave-end="opacity-0 scale-95">
                                                <button @click="rename = true; open = false"
                                                        class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                    Rename
                                                </button>
                                                <form action="{{ route('seller.store-categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Delete this collection? Products inside will become uncollected.')">
                                                    @csrf @method('DELETE')
                                                    <button class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="rename">
                                        <form action="{{ route('seller.store-categories.update', $cat->id) }}" method="POST"
                                              class="bg-white rounded-2xl border border-primary/40 shadow-md p-5 text-center">
                                            @csrf @method('PUT')
                                            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-3">
                                                <span class="material-symbols-outlined text-2xl">edit</span>
                                            </div>
                                            <input type="text" name="name" x-model="newName" required
                                                   class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-3 text-sm text-center font-bold focus:outline-none focus:ring-2 focus:ring-primary/30 mb-2">
                                            <div class="flex gap-2">
                                                <button type="submit"
                                                        class="flex-1 py-2 bg-primary text-white rounded-xl text-xs font-bold hover:opacity-90 transition-all">
                                                    Save
                                                </button>
                                                <button type="button" @click="rename = false; newName = '{{ $cat->name }}'"
                                                        class="flex-1 py-2 bg-white border border-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-50 transition-all">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </template>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @php $uncollected = $products->whereNull('store_category_id'); @endphp
                @if($uncollected->isNotEmpty())
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-1">
                            Uncollected
                            <span class="font-normal normal-case text-gray-300">({{ $uncollected->count() }})</span>
                        </h2>
                        @include('seller.products._list', ['products' => $uncollected])
                    </div>
                @endif

                @if($storeCategories->isEmpty() && $products->isEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-12 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-3xl text-gray-300">inventory_2</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">No products yet</h3>
                        <p class="text-sm text-gray-500 mt-1 max-w-sm mx-auto">Add your first product to start selling on the marketplace.</p>
                        <a href="{{ route('seller.products.create') }}"
                           class="inline-flex items-center gap-1.5 mt-5 px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Add Product
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-seller-layout>
