@props(['store', 'variant' => 'card'])

<img {{ $attributes->merge(['class' => 'w-full h-full object-cover']) }}
     src="{{ url('/r2/default-banner.jpg') }}"
     alt="Store banner">
