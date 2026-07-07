@extends('layouts.guest')
@section('title', 'Notifications — Izifai')
@section('content')
<div class="max-w-md mx-auto px-4 py-20 md:py-28 text-center">
    <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-4">
        <span class="material-symbols-outlined text-4xl text-gray-300">notifications_none</span>
    </div>
    <h3 class="text-lg font-bold text-gray-900">No notifications</h3>
    <p class="text-sm text-gray-500 mt-1">You're all caught up!</p>
    <a href="{{ url('/') }}" class="inline-block mt-6 px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all">Go Home</a>
</div>
@endsection