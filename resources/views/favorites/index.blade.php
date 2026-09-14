@extends('layouts.guest')

@section('title', 'Saved Items — Izifai')
@section('description', 'View and manage your saved products on Izifai.')

@push('styles')
<style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important; background-color: #f5f6f5; }
    .tnum { font-variant-numeric: tabular-nums; }
    .ecom-btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; border-radius: 9999px; font-weight: 600; transition: background .15s ease, transform .1s ease, box-shadow .2s ease; cursor: pointer; }
    .ecom-btn:active { transform: scale(.97); }
    .favorite-btn:active { transform: scale(0.85); }
    .favorite-btn.bumping { animation: favBump 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes favBump { 0% { transform: scale(1); } 40% { transform: scale(1.3); } 100% { transform: scale(1); } }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 pt-4 sm:pt-6 pb-16 sm:pb-24">

    {{-- ============ HERO / HEADER ============ --}}
    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-[#1c201e] border border-black/5 shadow-[0_14px_44px_-16px_rgba(0,0,0,0.18)] p-5 sm:p-10 text-white mb-6 sm:mb-8">
        <div class="absolute -top-24 -right-16 w-80 h-80 rounded-full bg-[#9acd32]/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-28 -left-16 w-72 h-72 rounded-full bg-[#7ca81d]/15 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 -skew-x-6 rounded-md bg-gradient-to-r from-[#9acd32] to-[#86b92c] text-[#1c201e] text-[10px] sm:text-[11px] font-extrabold uppercase tracking-[0.14em] shadow-[0_6px_18px_-6px_rgba(154,205,50,0.55)]">
                <span class="skew-x-6 inline-flex items-center gap-1">
                    <i class="fa-solid fa-heart text-[13px]"></i>
                    Wishlist
                </span>
            </span>

            <h1 class="mt-3 text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                Saved Items
            </h1>

            <p class="mt-1.5 text-xs sm:text-sm text-white/75 leading-relaxed">
                Products you've saved to keep track of deals and purchase later.
            </p>

            <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-white/80">
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32]"></span>
                    <strong class="text-white">{{ number_format($products->total()) }}</strong> item{{ $products->total() === 1 ? '' : 's' }} saved
                </span>
            </div>
        </div>
    </div>

    {{-- ============ PRODUCTS GRID ============ --}}
    @if($products->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-4 items-stretch">
            @foreach($products as $product)
                @include('partials.home-product-card', ['product' => $product, 'savedProductIds' => $savedProductIds])
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    @else
        {{-- Empty state --}}
        <div class="text-center py-16 sm:py-24 bg-white rounded-2xl sm:rounded-3xl border border-[#e8eae8] p-8 max-w-lg mx-auto shadow-sm">
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 rounded-full bg-[#f2f9df] text-[#7ca81d] grid place-items-center">
                <i class="fa-regular fa-heart text-3xl sm:text-4xl"></i>
            </div>
            <h2 class="text-base sm:text-xl font-bold text-[#1c201e]">No saved items yet</h2>
            <p class="text-xs sm:text-sm text-[#6b716c] mt-1.5 leading-relaxed">
                Browse our marketplace and tap the heart icon on any product to save it here for later.
            </p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="ecom-btn h-11 px-7 text-xs sm:text-sm bg-[#9acd32] text-[#1c201e] font-bold shadow-lg shadow-[#9acd32]/20 hover:bg-[#86b92c]">
                    Explore Products
                    <i class="fa-solid fa-arrow-right text-[16px]"></i>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
