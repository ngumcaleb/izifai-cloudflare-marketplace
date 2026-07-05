@extends('layouts.guest')

@section('title', $title ?? 'Seller Center')

@section('content')
    <div class="px-4 md:px-6 py-4 md:py-6 max-w-7xl mx-auto space-y-4 md:space-y-6">
        {{ $slot }}
    </div>
@endsection
