@props(['class' => 'h-12'])

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <!-- Handcrafted SVG Logo for Pixel-Perfect Scaling -->
    <svg viewBox="0 0 320 80" class="{{ $class }} w-auto overflow-hidden" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <!-- Shopping Bag Icon -->
        <defs>
            <linearGradient id="logoGradient" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#0A1D37" />
                <stop offset="100%" stop-color="#16A34A" />
            </linearGradient>
        </defs>

        <path d="M45 20H35V15C35 9.477 39.477 5 45 5C50.523 5 55 9.477 55 15V20H45Z" stroke="url(#logoGradient)"
            stroke-width="4" />
        <rect x="25" y="20" width="40" height="45" rx="8" fill="url(#logoGradient)" />
        <path d="M38 52L45 32L52 52H38Z" fill="white" />
        <rect x="42" y="44" width="6" height="3" fill="white" />

        <!-- Text: izi -->
        <text x="75" y="55" font-family="'Outfit', sans-serif" font-weight="800" font-size="42"
            fill="#0A1D37">izi</text>
        <!-- Text: fai -->
        <text x="130" y="55" font-family="'Outfit', sans-serif" font-weight="800" font-size="42"
            fill="#16A34A">fai</text>

        <!-- Slogan -->
        <line x1="75" y1="68" x2="100" y2="68" stroke="#16A34A" stroke-width="1" />
        <text x="105" y="72" font-family="'Outfit', sans-serif" font-weight="500" font-size="10" fill="#64748B"
            letter-spacing="2">SIMPLIFY YOUR SHOPPING</text>
        <line x1="255" y1="68" x2="280" y2="68" stroke="#16A34A" stroke-width="1" />
    </svg>
</div>