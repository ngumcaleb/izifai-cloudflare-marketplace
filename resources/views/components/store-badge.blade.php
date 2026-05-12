@props(['store', 'size' => 'md', 'showText' => true])

@php
    $isVerified = $store->is_verified;
    $badge = $store->badge;

    $colors = [
        'Premium Seller' => [
            'bg' => 'bg-red-50',
            'text' => 'text-red-600',
            'icon' => 'text-red-500',
            'border' => 'border-red-100',
            'dark_bg' => 'bg-red-600/20',
            'dark_text' => 'text-red-200',
            'dark_border' => 'border-red-500/30'
        ],
        'Trusted Store' => [
            'bg' => 'bg-amber-50',
            'text' => 'text-amber-600',
            'icon' => 'text-amber-500',
            'border' => 'border-amber-100',
            'dark_bg' => 'bg-amber-600/20',
            'dark_text' => 'text-amber-200',
            'dark_border' => 'border-amber-500/30'
        ],
        'Verified Seller' => [
            'bg' => 'bg-green-50',
            'text' => 'text-green-600',
            'icon' => 'text-green-500',
            'border' => 'border-green-100',
            'dark_bg' => 'bg-green-600/20',
            'dark_text' => 'text-green-200',
            'dark_border' => 'border-green-500/30'
        ],
        'default' => [
            'bg' => 'bg-slate-100',
            'text' => 'text-slate-600',
            'icon' => 'text-slate-400',
            'border' => 'border-slate-200',
            'dark_bg' => 'bg-slate-800/40',
            'dark_text' => 'text-slate-300',
            'dark_border' => 'border-slate-700'
        ]
    ];

    $style = $colors[$badge] ?? $colors['default'];

    $iconSize = $size === 'sm' ? 'w-2 h-2' : ($size === 'lg' ? 'w-4 h-4' : 'w-3 h-3');
    $textSize = $size === 'sm' ? 'text-[6px]' : ($size === 'lg' ? 'text-[10px]' : 'text-[8px]');
    $padding = $size === 'sm' ? 'px-1 py-0.5' : ($size === 'lg' ? 'px-3 py-1' : 'px-2 py-0.5');
@endphp

@if($isVerified)
    <div {{ $attributes->merge(['class' => "inline-flex items-center gap-1 $padding rounded-full border $textSize font-black uppercase tracking-wider transition-all " . ($attributes->get('dark') ? "{$style['dark_bg']} {$style['dark_border']} {$style['dark_text']}" : "{$style['bg']} {$style['border']} {$style['text']}")]) }}>
        @if($badge)
            <svg class="{{ $iconSize }} {{ $attributes->get('dark') ? '' : $style['icon'] }}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
            @if($showText)
                <span>{{ $badge }}</span>
            @endif
        @else
            <svg class="{{ $iconSize }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
            @if($showText)
                <span>Registered Merchant</span>
            @endif
        @endif
    </div>
@else
    <div {{ $attributes->merge(['class' => "inline-flex items-center gap-1 $padding rounded-full border border-slate-100 bg-slate-50 text-slate-400 $textSize font-black uppercase tracking-wider"]) }}>
        <svg class="{{ $iconSize }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
        </svg>
        @if($showText)
            <span>Standard Seller</span>
        @endif
    </div>
@endif
