@extends('layouts.guest')
@section('title', 'Page Not Found — Izifai')
@section('content')
<div class="max-w-md mx-auto px-4 py-20 md:py-28 text-center">
    <div class="w-20 h-20 rounded-3xl bg-amber-50 flex items-center justify-center mx-auto mb-6">
        <i class="fa-solid fa-magnifying-glass text-5xl text-amber-400"></i>
    </div>
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Page Not Found</h1>
    <p class="text-sm text-gray-500 mt-2 leading-relaxed">The page you're looking for doesn't exist or has been moved.</p>
    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-6">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all">
            <i class="fa-solid fa-house text-[18px]"></i>
            Go Home
        </a>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all">
            <i class="fa-solid fa-bag-shopping text-[18px]"></i>
            Browse Products
        </a>
    </div>
</div>
@endsection