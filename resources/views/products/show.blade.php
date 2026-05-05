<x-app-layout>
    <main class="max-w-[1400px] mx-auto px-4 md:px-6 py-6" x-data="{ reportModal: false, reportReason: '' }">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[12px] text-slate-500 mb-6 font-medium">
            <a href="/" class="hover:text-green-600">Home</a> <span class="text-slate-300">></span>
            <a href="#" class="hover:text-green-600">{{ $product->category->name }}</a> <span class="text-slate-300">></span>
            <span class="text-slate-800">{{ $product->name }}</span>
        </nav>

        <!-- Product Title Row (Spans across) -->
        <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
            <h1 class="text-2xl md:text-3xl font-black text-[#0A1D37] tracking-tight">{{ $product->name }}</h1>
            @if($product->old_price)
                <span class="bg-[#16A34A] text-white text-[11px] font-bold px-2 py-1 rounded uppercase tracking-wider">Sale</span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
            <!-- Left: Product Gallery (Col span 4) -->
            <div class="lg:col-span-4" x-data="{ currentImage: '{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}' }">
                <div class="mb-4">
                    <div class="aspect-[4/5] rounded bg-white border border-slate-200 mb-4 overflow-hidden flex items-center justify-center p-6">
                        <img :src="currentImage" class="w-full h-full object-contain transition-all duration-300">
                    </div>
                    @if($product->images->count() > 0)
                        <div class="grid grid-cols-5 gap-2">
                            @foreach($product->images as $index => $image)
                            <div @click="currentImage = '{{ asset('storage/' . $image->path) }}'" 
                                class="aspect-square rounded border-2 p-1 overflow-hidden cursor-pointer transition-colors bg-white flex items-center justify-center"
                                :class="currentImage === '{{ asset('storage/' . $image->path) }}' ? 'border-green-600' : 'border-slate-200 hover:border-green-400'">
                                <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Middle: Product Info & Actions (Col span 5) -->
            <div class="lg:col-span-5">
                <div class="flex items-baseline gap-4 mb-3">
                    <span class="text-3xl font-black text-[#0A1D37]">{{ number_format($product->price) }} XAF</span>
                    @if($product->old_price)
                        <span class="text-[14px] text-slate-400 font-bold line-through">{{ number_format($product->old_price) }} XAF</span>
                    @endif
                </div>

                <div class="flex items-center gap-2 mb-8">
                    <div class="w-2 h-2 {{ $product->stock_status == 'in_stock' ? 'bg-green-500' : ($product->stock_status == 'out_of_stock' ? 'bg-red-500' : 'bg-orange-500') }} rounded-full"></div>
                    <span class="text-[13px] font-bold {{ $product->stock_status == 'in_stock' ? 'text-green-600' : ($product->stock_status == 'out_of_stock' ? 'text-red-600' : 'text-orange-600') }}">
                        {{ ucwords(str_replace('_', ' ', $product->stock_status)) }}
                    </span>
                </div>

                <!-- Variants (Colors) -->
                @if($product->colors && count($product->colors) > 0)
                <div class="mb-6">
                    <h4 class="text-[14px] font-black text-[#0A1D37] mb-3">Available Colors</h4>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $colorMap = [
                                // Blacks
                                'black' => '#000000', 'jet black' => '#0A0A0A', 'matte black' => '#1A1A1A', 'charcoal' => '#36454F', 'ash' => '#B2BEB5', 'graphite' => '#41424C', 'smoke' => '#738276', 'onyx' => '#353839', 'coal' => '#2A3439', 'ink' => '#000F55', 'raven' => '#050301',
                                // Whites
                                'white' => '#FFFFFF', 'pure white' => '#FFFFFF', 'off white' => '#FAF9F6', 'ivory' => '#FFFFF0', 'cream' => '#FFFDD0', 'snow' => '#FFFAFA', 'pearl' => '#EAE0C8', 'milky white' => '#FDFFF5', 'eggshell' => '#F0EAD6', 'linen' => '#FAF0E6',
                                // Greys
                                'grey' => '#808080', 'gray' => '#808080', 'light grey' => '#D3D3D3', 'dark grey' => '#A9A9A9', 'slate' => '#708090', 'steel' => '#4682B4', 'silver grey' => '#C0C0C0', 'gunmetal' => '#2A3439', 'pewter' => '#8E9CB2', 'dove grey' => '#6D6C6C',
                                // Browns
                                'brown' => '#8B4513', 'dark brown' => '#5C4033', 'light brown' => '#C4A484', 'chocolate' => '#D2691E', 'chocolate brown' => '#7B3F00', 'coffee' => '#6F4E37', 'coffee brown' => '#4A2C2A', 'mocha' => '#493D26', 'cocoa' => '#D2691E', 'walnut' => '#773F1A', 'chestnut' => '#954535', 'caramel' => '#FFD59A', 'toffee' => '#E38C2D', 'bronze' => '#CD7F32', 'rust' => '#B7410E', 'umber' => '#635147', 'sepia' => '#704214', 'mahogany' => '#C04000', 'sienna' => '#882D17', 'earth brown' => '#5C4033',
                                // Beiges
                                'beige' => '#F5F5DC', 'sand' => '#C2B280', 'nude' => '#E3BC9A', 'tan' => '#D2B48C', 'khaki' => '#C3B091', 'camel' => '#C19A6B', 'wheat' => '#F5DEB3', 'stone' => '#877F6C', 'almond' => '#EED9C4', 'biscuit' => '#FFE4C4',
                                // Reds
                                'red' => '#FF0000', 'bright red' => '#EE4B2B', 'deep red' => '#8B0000', 'wine' => '#722F37', 'wine red' => '#722F37', 'burgundy' => '#800020', 'maroon' => '#800000', 'scarlet' => '#FF2400', 'crimson' => '#DC143C', 'cherry' => '#D2042D', 'blood red' => '#660000', 'ruby' => '#E0115F', 'garnet' => '#733635',
                                // Pinks
                                'pink' => '#FFC0CB', 'light pink' => '#FFB6C1', 'hot pink' => '#FF69B4', 'rose' => '#FF007F', 'baby pink' => '#F4C2C2', 'blush' => '#DE5D83', 'coral pink' => '#F88379', 'salmon' => '#FA8072', 'fuchsia' => '#FF00FF', 'magenta' => '#FF00FF',
                                // Blues
                                'blue' => '#0000FF', 'sky blue' => '#87CEEB', 'light blue' => '#ADD8E6', 'baby blue' => '#89CFF0', 'navy blue' => '#000080', 'royal blue' => '#4169E1', 'deep blue' => '#00008B', 'ocean blue' => '#0077BE', 'aqua' => '#00FFFF', 'teal' => '#008080', 'turquoise' => '#40E0D0', 'cyan' => '#00FFFF', 'ice blue' => '#99FFFF', 'sapphire' => '#0F52BA', 'cobalt' => '#0047AB', 'azure' => '#007FFF', 'midnight blue' => '#191970',
                                // Greens
                                'green' => '#008000', 'light green' => '#90EE90', 'dark green' => '#006400', 'forest green' => '#228B22', 'olive' => '#808000', 'army green' => '#4B5320', 'lime green' => '#32CD32', 'mint' => '#3EB489', 'emerald' => '#50C878', 'jade' => '#00A86B', 'moss' => '#8A9A5B', 'pine' => '#01796F', 'sea green' => '#2E8B57', 'ocean green' => '#48BF91',
                                // Yellows
                                'yellow' => '#FFFF00', 'bright yellow' => '#FFEA00', 'lemon' => '#FFF700', 'mustard' => '#FFDB58', 'golden yellow' => '#FFDF00', 'amber' => '#FFBF00', 'honey' => '#FFC30B', 'butter' => '#FFFDD0', 'canary' => '#FFFF99',
                                // Oranges
                                'orange' => '#FFA500', 'bright orange' => '#FF8C00', 'burnt orange' => '#CC5500', 'peach' => '#FFE5B4', 'apricot' => '#FBCEB1', 'tangerine' => '#F28500', 'coral' => '#FF7F50',
                                // Purples
                                'purple' => '#800080', 'deep purple' => '#36013F', 'light purple' => '#CBC3E3', 'violet' => '#EE82EE', 'lavender' => '#E6E6FA', 'lilac' => '#C8A2C8', 'plum' => '#DDA0DD', 'mauve' => '#E0B0FF', 'indigo' => '#4B0082', 'orchid' => '#DA70D6',
                                // Metals
                                'gold' => '#FFD700', 'metallic gold' => '#D4AF37', 'champagne gold' => '#F7E7CE', 'rose gold' => '#B76E79',
                                'silver' => '#C0C0C0', 'metallic silver' => '#AAA9AD', 'chrome' => '#D8D8D8',
                                'copper' => '#B87333', 'brass' => '#B5A642',
                                // Others
                                'transparent' => 'transparent', 'clear' => 'transparent',
                                'multicolor' => 'linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet)', 'mixed' => 'linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet)', 
                                'patterned' => 'repeating-linear-gradient(45deg, #e5e5f7 25%, transparent 25%, transparent 75%, #e5e5f7 75%, #e5e5f7), repeating-linear-gradient(45deg, #e5e5f7 25%, transparent 25%, transparent 75%, #e5e5f7 75%, #e5e5f7)', 
                                'printed' => '#E5E4E2', 'floral' => 'linear-gradient(to right, #FFC0CB, #90EE90)', 
                                'striped' => 'repeating-linear-gradient(45deg, #333, #333 4px, #fff 4px, #fff 8px)', 
                                'checked' => 'repeating-linear-gradient(45deg, #333 25%, transparent 25%, transparent 75%, #333 75%, #333)', 
                                'gradient' => 'linear-gradient(to right, #ff7e5f, #feb47b)',
                                // Denims
                                'denim' => '#1560BD', 'washed blue' => '#7A91B4', 'faded blue' => '#7A91B4',
                                // Neons
                                'neon green' => '#39FF14', 'neon yellow' => '#FFFF33', 'neon pink' => '#FF10F0', 'neon orange' => '#FF6700', 'neon blue' => '#1F51FF',
                                // Pastels
                                'pastel blue' => '#AEC6CF', 'pastel pink' => '#FFD1DC', 'pastel green' => '#77DD77', 'pastel yellow' => '#FDFD96', 'pastel purple' => '#C3B1E1',
                                // Mixes
                                'coffee mix' => 'linear-gradient(to right, #6F4E37, #C4A484)', 'chocolate mix' => 'linear-gradient(to right, #7B3F00, #D2691E)'
                            ];

                            $getStyle = function($color) use ($colorMap) {
                                $clean = strtolower(trim($color));
                                if (str_starts_with($clean, '#')) return "background-color: $clean;";
                                
                                $mapped = $colorMap[$clean] ?? '#ffffff';
                                
                                if (str_contains($mapped, 'gradient')) {
                                    if (in_array($clean, ['patterned', 'checked'])) {
                                        return "background-image: $mapped; background-size: 8px 8px; background-position: 0 0, 4px 4px;";
                                    }
                                    return "background: $mapped;";
                                }
                                return "background-color: $mapped;";
                            };
                        @endphp
                        @foreach($product->colors as $color)
                            <button 
                                class="group relative flex flex-col items-center gap-1"
                                title="{{ ucfirst($color) }}"
                            >
                                <div 
                                    class="w-8 h-8 rounded-full border-2 border-slate-200 group-hover:border-green-600 transition-all p-0.5 shadow-sm"
                                    :class="selectedColor === '{{ $color }}' ? 'border-green-600 ring-2 ring-green-100' : ''"
                                >
                                    <div class="w-full h-full rounded-full border border-black/5 {{ strtolower(trim($color)) === 'transparent' || strtolower(trim($color)) === 'clear' ? 'bg-stripe-pattern' : '' }}" 
                                         style="{{ $getStyle($color) }}">
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter">{{ $color }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Sizes / Storage -->
                @if($product->sizes && count($product->sizes) > 0)
                <div class="mb-8">
                    <h4 class="text-[14px] font-black text-[#0A1D37] mb-3">Select Size / Storage</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->sizes as $size)
                            <button class="px-4 py-1.5 bg-white border-2 border-slate-200 text-[12px] font-bold text-slate-700 rounded hover:border-green-600 transition-colors">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Primary Actions -->
                <div class="space-y-3 mb-6">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp_number) }}?text=Hello, I am interested in your product: {{ urlencode($product->name) }}" 
                       target="_blank"
                       class="w-full bg-[#16A34A] text-white py-3.5 rounded-md font-bold text-[15px] flex items-center justify-center gap-2 hover:bg-green-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Contact on WhatsApp
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp_number) }}" 
                       class="w-full bg-slate-50 text-slate-800 border border-slate-200 py-3.5 rounded-md font-bold text-[15px] flex items-center justify-center gap-2 hover:bg-slate-100 transition-colors shadow-sm">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Call Seller
                    </a>
                </div>

                <div class="flex items-center gap-6 text-[13px] font-medium text-slate-600 mb-10 pb-6 border-b border-slate-100" 
                     x-data="{ isFavorite: {{ auth()->check() && auth()->user()->savedProducts->contains($product->id) ? 'true' : 'false' }}, copied: false }">
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>{{ number_format($product->views) }} views</span>
                    </div>
                    <button 
                        @click="
                            @auth
                                fetch('{{ route('products.toggle-favorite', $product->id) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } })
                                .then(res => res.json())
                                .then(data => { isFavorite = data.favorited; })
                            @else
                                window.location = '{{ route('login') }}'
                            @endauth
                        " 
                        class="flex items-center gap-1.5 transition-colors"
                        :class="isFavorite ? 'text-red-500' : 'hover:text-red-500'"
                    >
                        <svg class="w-5 h-5" :class="isFavorite ? 'fill-red-500' : ''" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> 
                        <span x-text="isFavorite ? 'Saved to Favorites' : 'Save Product'"></span>
                    </button>
                    <button 
                        @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" 
                        class="flex items-center gap-1.5 hover:text-green-600 transition-colors"
                    >
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg> 
                        <span x-text="copied ? 'Link Copied!' : 'Share'"></span>
                    </button>
                </div>

                <!-- Short Description -->
                <div>
                    <h3 class="text-lg font-black text-[#0A1D37] mb-4">Specifications</h3>
                    <div class="grid grid-cols-2 gap-y-3 text-[13px]">
                        @forelse($product->specifications as $spec)
                            <div class="flex gap-2"><span class="text-slate-500 w-24 shrink-0">{{ $spec->key }}:</span> <span class="font-bold text-slate-800">{{ $spec->value }}</span></div>
                        @empty
                            <div class="text-slate-500">No specifications added.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right: Seller Info (Col span 3) -->
            <div class="lg:col-span-3">
                <!-- Box 1 -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 mb-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-12 h-12 rounded-full bg-[#0A1D37] flex items-center justify-center text-white font-black text-lg shrink-0 overflow-hidden border border-slate-100">
                            @if($product->store->logo)
                                <img src="{{ asset('storage/' . $product->store->logo) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($product->store->name, 0, 2) }}
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-[#0A1D37] text-[15px] leading-tight flex items-center gap-1">
                                {{ $product->store->name }} <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </h3>
                        </div>
                    </div>

                    <div class="space-y-3 text-[13px] text-slate-600 mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04c-.243.39-.314.906-.314 1.414 0 6.666 4.721 12.23 11.089 13.914l.111.028.111-.028C19.279 19.584 24 14.02 24 7.354c0-.508-.071-1.024-.314-1.414z"></path></svg>
                            <span class="font-medium text-slate-800">Verified Seller</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            {{ $product->store->products()->count() }} products
                        </div>
                    </div>

                    <a href="{{ route('stores.show', $product->store->slug) }}" class="w-full bg-[#1e588f] text-white py-2.5 rounded font-bold text-[13px] hover:bg-blue-800 transition-all mb-3 flex items-center justify-center">View Store</a>
                    
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp_number) }}" 
                           class="bg-slate-50 border border-slate-200 text-slate-700 py-2 rounded text-[12px] font-medium flex items-center justify-center gap-1.5 hover:bg-slate-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> Call Seller
                        </a>
                        <button 
                            @click="navigator.clipboard.writeText(window.location.href); alert('Product link copied to clipboard!')"
                            class="bg-slate-50 border border-slate-200 text-slate-700 py-2 rounded text-[12px] font-medium flex items-center justify-center gap-1.5 hover:bg-slate-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Save link
                        </button>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                        <div class="flex gap-2">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp_number) }}" 
                               target="_blank"
                               class="w-7 h-7 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </a>
                            <a href="tel:{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp_number) }}" 
                               class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </a>
                        </div>
                        <button @click="reportModal = true" class="text-[11px] text-slate-500 font-medium flex items-center gap-1 hover:text-red-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg> Report listing
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Modal -->
        <div x-show="reportModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="reportModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" 
                     @click="reportModal = false"></div>

                <div x-show="reportModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block w-full max-w-lg p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-black text-[#0A1D37]">Report Listing</h3>
                        <button @click="reportModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <p class="text-sm text-slate-500 mb-6 font-medium">Please select the reason for reporting this listing. Our team will review it shortly.</p>

                    <div class="space-y-3 mb-8">
                        <template x-for="reason in ['Fraudulent content', 'Counterfeit product', 'Inappropriate images', 'Incorrect pricing', 'Other issues']">
                            <label class="flex items-center gap-3 p-4 border-2 border-slate-50 rounded-xl cursor-pointer hover:border-red-100 hover:bg-red-50/30 transition-all"
                                   :class="reportReason === reason ? 'border-red-500 bg-red-50/50' : ''">
                                <input type="radio" name="reason" :value="reason" x-model="reportReason" class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300">
                                <span class="text-sm font-bold text-slate-700" x-text="reason"></span>
                            </label>
                        </template>
                    </div>

                    <div class="flex gap-3">
                        <button @click="reportModal = false" class="flex-1 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest text-slate-500 bg-slate-50 hover:bg-slate-100 transition-all">Cancel</button>
                        <button @click="if(reportReason) { alert('Thank you! Your report for ' + reportReason + ' has been submitted.'); reportModal = false; }" 
                                class="flex-1 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest text-white bg-red-500 hover:bg-red-600 shadow-lg shadow-red-500/20 transition-all">
                            Submit Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description Full text -->
        <div class="mb-12 border-t border-slate-200 pt-8">
            <h2 class="text-xl font-bold text-[#0A1D37] mb-6">Product Description</h2>
            <div class="prose prose-sm max-w-none text-slate-600 space-y-4">
                <p class="leading-relaxed">{{ $product->description }}</p>
            </div>
        </div>

        <!-- Additional Specifications Product Carousel -->
        <div class="mb-12 border-t border-slate-200 pt-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-[#0A1D37]">Additional Specifications</h2>
                <a href="#" class="text-[13px] font-bold text-slate-500 hover:text-green-600">View All >></a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->with(['images', 'store'])
                        ->take(4)
                        ->get();
                @endphp
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->slug) }}" class="bg-white rounded-lg border border-slate-200 p-3 hover:shadow-xl transition-all group block">
                    <div class="relative bg-white rounded-lg aspect-square mb-3 flex items-center justify-center border border-slate-100 overflow-hidden">
                        <img src="{{ $related->images->first() ? asset('storage/' . $related->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}" 
                            class="w-[80%] h-[80%] object-contain group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <h3 class="text-[13px] font-medium text-slate-800 line-clamp-1 mb-1">{{ $related->name }}</h3>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[14px] font-black text-[#0A1D37]">{{ number_format($related->price) }} XAF</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[11px] text-slate-500 pt-2 border-t border-slate-50">
                        <div class="w-3.5 h-3.5 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                        </div>
                        <span class="truncate">{{ $related->store->name ?? 'Verified Store' }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        </div>

        <!-- Business Discovery Section -->
        <div class="mt-12 border-t border-slate-200 pt-8">
            <x-featured-businesses title="Recommended Sellers" limit="3" />
        </div>
    </main>
</x-app-layout>
