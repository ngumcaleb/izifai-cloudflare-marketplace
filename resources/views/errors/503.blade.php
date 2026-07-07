@extends('layouts.guest')
@section('title', 'Under Maintenance — Izifai')
@section('content')
<div class="max-w-md mx-auto px-4 py-20 md:py-28 text-center">
    <div class="w-20 h-20 rounded-3xl bg-blue-50 flex items-center justify-center mx-auto mb-6">
        <span class="material-symbols-outlined text-5xl text-blue-400">construction</span>
    </div>
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Under Maintenance</h1>
    <p class="text-sm text-gray-500 mt-2 leading-relaxed">We're making some improvements. We'll be back shortly.</p>
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all">
        <span class="material-symbols-outlined text-[18px]">refresh</span>
        Try Again
    </a>
</div>
@endsection