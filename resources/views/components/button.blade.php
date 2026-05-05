@props(['variant' => 'primary', 'size' => 'md'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variants = [
        'primary' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 shadow-sm hover:shadow-md',
        'secondary' => 'bg-blue-900 text-white hover:bg-blue-950 focus:ring-blue-800 shadow-sm hover:shadow-md',
        'outline' => 'bg-transparent border-2 border-slate-200 text-slate-700 hover:border-slate-300 hover:bg-slate-50 focus:ring-slate-400',
        'white' => 'bg-white text-slate-900 hover:bg-slate-50 border border-slate-200 shadow-sm',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900',
        'whatsapp' => 'bg-[#25D366] text-white hover:bg-[#128C7E] focus:ring-[#25D366] shadow-sm',
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-8 py-3.5 text-base',
        'icon' => 'p-2',
    ];
    
    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
