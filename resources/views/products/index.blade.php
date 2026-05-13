@extends('layouts.public')
@section('title', $title . ' — Izifai')
@section('description', $description)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 sm:py-8">

    @php $heroProducts = array_slice($products->items(), 0, 4); @endphp

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-br from-surface-container-lowest via-surface-container-lowest to-primary/5 border border-outline-variant/10 mb-6 sm:mb-8">
        <div class="flex flex-col lg:flex-row items-center gap-4 lg:gap-6 p-4 sm:p-6 lg:p-8">

            {{-- Decorative floating product cards --}}
            @if(count($heroProducts) > 0)
            <div class="relative w-36 h-28 sm:w-48 sm:h-36 shrink-0 order-first lg:order-last">
                @foreach($heroProducts as $i => $p)
                    @php
                        $rotations = ['-rotate-6', 'rotate-3', 'rotate-12', '-rotate-3'];
                        $tops = ['top-0', 'top-1', 'bottom-2', 'bottom-0'];
                        $lefts = ['left-0', 'right-3', 'left-5', 'right-0'];
                        $z = ['z-10', 'z-20', 'z-30', 'z-40'];
                    @endphp
                    <div class="absolute {{ $tops[$i] }} {{ $lefts[$i] }} {{ $z[$i] }} {{ $rotations[$i] }} w-12 h-12 sm:w-[68px] sm:h-[68px] rounded-xl sm:rounded-2xl overflow-hidden shadow-lg border-2 border-white bg-surface-container-lowest transition-transform duration-300 hover:scale-110 hover:-rotate-2">
                        @if($p->images->first())
                            <img src="{{ asset('storage/' . $p->images->first()->path) }}" class="w-full h-full object-cover" alt="">
                        @else
                            <div class="w-full h-full bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-lg">shopping_bag</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif

            {{-- Text content --}}
            <div class="flex-1 min-w-0 text-center lg:text-left">
                <h1 class="text-lg sm:text-2xl lg:text-3xl font-black text-on-surface tracking-tight">{{ $title }}</h1>
                <p class="text-[11px] sm:text-sm text-on-surface-variant mt-0.5 max-w-md mx-auto lg:mx-0">
                    Cameroon's marketplace for authentic products. Izifai connects you directly with trusted sellers.
                </p>
                <p class="text-sm sm:text-base font-bold text-primary mt-1">
                    <span class="text-xl sm:text-2xl font-black">{{ $products->total() }}</span> products
                </p>
            </div>
        </div>

        {{-- Search --}}
        <div class="px-4 sm:px-6 lg:px-8 pb-4 sm:pb-6 lg:pb-8">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-col sm:flex-row gap-2 max-w-xl lg:max-w-lg">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                           class="w-full h-10 pl-10 pr-3 bg-surface-container-low border border-outline-variant/30 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                </div>
                <button type="submit"
                        class="h-10 px-5 bg-primary text-on-primary rounded-lg text-xs font-bold hover:opacity-90 transition-all shadow-sm whitespace-nowrap">
                    Search
                </button>
            </form>
        </div>
    </div>

    {{-- Product Grid --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 sm:gap-3">
            @foreach($products as $product)
                <div class="bg-surface-container-lowest rounded-lg sm:rounded-xl overflow-hidden shadow-sm border border-outline-variant/10 hover:shadow-md transition-all group relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="aspect-square relative overflow-hidden bg-surface-container-high">
                            @if($product->images->first())
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                    <span class="material-symbols-outlined text-3xl">image</span>
                                </div>
                            @endif
                            @if($product->old_price)
                                <span class="absolute top-1.5 left-1.5 bg-error text-on-error text-[8px] font-bold px-1.5 py-0.5 rounded-full">
                                    -{{ round((1 - $product->price / $product->old_price) * 100) }}%
                                </span>
                            @endif
                        </div>
                        <div class="p-1.5 sm:p-3">
                            @if($product->category)
                                <p class="text-[7px] sm:text-[10px] font-semibold text-primary uppercase truncate">{{ $product->category->name }}</p>
                            @endif
                            <h3 class="text-[11px] sm:text-sm font-bold text-on-surface truncate leading-tight">{{ $product->name }}</h3>
                            @if($product->store)
                                <p class="text-[8px] sm:text-[10px] text-on-surface-variant truncate">{{ $product->store->name }}</p>
                            @endif
                            <p class="text-xs sm:text-base font-black text-primary mt-0.5 truncate">{{ number_format($product->price) }} FCFA</p>
                            @if($product->old_price)
                                <p class="text-[9px] sm:text-[11px] text-on-surface-variant line-through truncate">{{ number_format($product->old_price) }} FCFA</p>
                            @endif
                        </div>
                    </a>
                    <button class="favorite-btn absolute top-1.5 right-1.5 sm:top-2 sm:right-2 w-5 h-5 sm:w-7 sm:h-7 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors z-10"
                            data-product="{{ $product->id }}"
                            data-favorited="{{ in_array($product->id, $savedProductIds ?? []) ? 'true' : 'false' }}">
                        <span class="material-symbols-outlined text-[10px] sm:text-[14px]"
                              style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds ?? []) ? 1 : 0 }};">favorite</span>
                    </button>
                </div>
            @endforeach
        </div>

        <div class="mt-6 sm:mt-8">
            {{ $products->links('partials.pagination') }}
        </div>
    @else
        <div class="text-center py-12 sm:py-16 bg-surface-container-low rounded-xl sm:rounded-2xl border border-outline-variant/10">
            <span class="material-symbols-outlined text-4xl sm:text-5xl text-outline-variant">inventory_2</span>
            <h3 class="text-base sm:text-lg font-bold text-on-surface-variant mt-3">No products found</h3>
            @if(request('q'))
                <p class="text-sm text-on-surface-variant mt-1">No results for "{{ request('q') }}"</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2 bg-primary text-on-primary rounded-full text-xs font-bold hover:opacity-90 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                    Clear Search
                </a>
            @else
                <p class="text-sm text-on-surface-variant mt-1">Check back soon for new products</p>
            @endif
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.favorite-btn');
        if (!btn) return;
        e.preventDefault();
        const productId = btn.dataset.product;
        const isFav = btn.dataset.favorited === 'true';
        @auth
            fetch('{{ url('/products') }}/' + productId + '/favorite', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                const icon = btn.querySelector('.material-symbols-outlined');
                if (data.favorited) {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    btn.dataset.favorited = 'true';
                } else {
                    icon.style.fontVariationSettings = "'FILL' 0";
                    btn.dataset.favorited = 'false';
                }
            });
        @endauth
        @guest
            window.location.href = '{{ route('login') }}';
        @endguest
    });
</script>
@endpush
