<x-seller-layout>
    <x-slot name="title">Store Categories</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Store Categories</h1>
                <p class="text-sm text-gray-500 mt-0.5">Custom categories for your store</p>
            </div>
            <a href="{{ route('seller.store-categories.create') }}"
               class="whitespace-nowrap flex items-center justify-center gap-1.5 bg-primary text-white px-4 py-2 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>New Category</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 divide-y divide-gray-50">
            @forelse($categories as $cat)
                <div class="px-5 py-4 flex items-center justify-between gap-4 hover:bg-gray-50/50 transition-all">
                    <div class="min-w-0 flex-1">
                        <h4 class="text-sm font-bold text-gray-900">{{ $cat->name }}</h4>
                        @if($cat->children->count() > 0)
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $cat->children->pluck('name')->join(', ') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('seller.store-categories.edit', $cat->id) }}"
                           class="p-2 text-gray-400 hover:text-primary hover:bg-gray-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form action="{{ route('seller.store-categories.destroy', $cat->id) }}" method="POST"
                              onsubmit="return confirm('Delete this category? Subcategories will be unlinked.')">
                            @csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-3xl text-gray-300">category</span>
                    </div>
                    <p class="text-base font-bold text-gray-900">No custom categories</p>
                    <p class="text-sm text-gray-500 mt-1">Create categories specific to your store.</p>
                    <a href="{{ route('seller.store-categories.create') }}"
                       class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Create Category
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-seller-layout>
