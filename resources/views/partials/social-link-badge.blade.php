@if(!empty($social['url']))
    @php
        $platform = $social['platform'] ?? '';
        $brand = match($platform) {
            'facebook' => 'hover:bg-[#1877F2]',
            'instagram' => 'hover:bg-[#E1306C]',
            'twitter' => 'hover:bg-[#000000]',
            'linkedin' => 'hover:bg-[#0A66C2]',
            'tiktok' => 'hover:bg-[#010101]',
            'youtube' => 'hover:bg-[#FF0000]',
            'whatsapp_group' => 'hover:bg-[#25D366]',
            default => 'hover:bg-[#1c201e]',
        };
        $icon = match($platform) {
            'facebook' => 'fa-brands fa-facebook',
            'instagram' => 'fa-brands fa-instagram',
            'twitter' => 'fa-brands fa-x-twitter',
            'linkedin' => 'fa-brands fa-linkedin-in',
            'tiktok' => 'fa-brands fa-tiktok',
            'youtube' => 'fa-brands fa-youtube',
            'whatsapp_group' => 'fa-brands fa-whatsapp',
            default => 'fa-solid fa-globe',
        };
    @endphp
    <a href="{{ $social['url'] }}" target="_blank" rel="noopener"
       class="inline-flex items-center gap-2 px-3.5 h-10 bg-[#f5f6f5] text-[#3f453f] rounded-xl text-[11px] font-bold transition-all duration-200 border border-[#e8eae8] hover:border-transparent hover:text-white {{ $brand }}">
        <i class="{{ $icon }} text-[14px]" style=""></i>
        {{ ucfirst(str_replace('_', ' ', $platform)) }}
    </a>
@endif