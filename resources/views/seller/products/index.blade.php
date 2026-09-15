<x-seller-layout>
    <x-slot name="title">My Products</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">My Products</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $products->count() }} product(s)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seller.products.create') }}"
                   class="whitespace-nowrap flex items-center justify-center gap-1.5 bg-primary text-white px-4 py-2 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                    <i class="fa-solid fa-plus text-[18px]"></i>
                    <span>Add Product</span>
                </a>
            </div>
        </div>

        @include('seller.products._list', ['products' => $products])
    </div>
</x-seller-layout>