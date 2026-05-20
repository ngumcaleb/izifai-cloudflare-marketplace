@props(['store', 'size' => 'md'])

@php
    $sizes = [
        'xs' => 'w-7 h-7',
        'sm' => 'w-8 h-8',
        'md' => 'w-10 h-10',
        'lg' => 'w-14 h-14',
        'xl' => 'w-20 h-20',
        '2xl' => 'w-24 h-24',
    ];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

<img {{ $attributes->merge(['class' => "$sizeClasses object-cover"]) }}
     src="{{ url('/r2/default-logo.jpg') }}"
     alt="Store logo">
