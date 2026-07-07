@extends('layouts.guest')
@section('title', 'Access Denied — Izifai')
@section('content')
<div class="max-w-md mx-auto px-4 py-20 md:py-28 text-center">
    <div class="w-20 h-20 rounded-3xl bg-red-50 flex items-center justify-center mx-auto mb-6">
        <span class="material-symbols-outlined text-5xl text-red-400">lock</span>
    </div>
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Access Denied</h1>
    <p class="text-sm text-gray-500 mt-2 leading-relaxed">You don't have permission to access this page.</p>
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all">
        <span class="material-symbols-outlined text-[18px]">home</span>
        Go Home
    </a>
</div>
@endsection