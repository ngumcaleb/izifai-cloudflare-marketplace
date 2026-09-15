@extends('layouts.guest')

@push('styles')
<style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important; background-color: #f5f6f5; }

    .tnum { font-variant-numeric: tabular-nums; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .reviews-scroll { scrollbar-width: thin; scrollbar-color: #d6d9d6 transparent; -webkit-mask-image: linear-gradient(to bottom, black calc(100% - 24px), transparent 100%); mask-image: linear-gradient(to bottom, black calc(100% - 24px), transparent 100%); }
    .reviews-scroll::-webkit-scrollbar { width: 4px; }
    .reviews-scroll::-webkit-scrollbar-thumb { background: #d8dbd8; border-radius: 9999px; }
    .reviews-scroll::-webkit-scrollbar-track { background: transparent; }
</style>
@endpush

@php
$store = $rental->store;
$whatsappIcon = '<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
$rentalImages = $rental->images_url;
$cover = $rental->main_image_url ?: ($rentalImages[0] ?? '');
@endphp

@section('title', $rental->name . ' - ' . $store->name . ' | Izifai')
@section('description', (strip_tags($rental->description ?? '') ?: $rental->name . ' on Izifai'))
@section('og_title', $rental->name . ' - ' . $store->name)
@section('og_description', str(strip_tags($rental->description ?? '') ?: $rental->name . ' on Izifai')->limit(160))
@section('og_image', $cover ?: asset('images/logo.png'))
@section('og_type', 'website')
@section('twitter_title', $rental->name . ' - ' . $store->name)
@section('twitter_description', str(strip_tags($rental->description ?? '') ?: $rental->name . ' on Izifai')->limit(160))
@section('twitter_image', $cover ?: asset('images/logo.png'))

@section('header-search')
<div class="hidden sm:flex flex-1 max-w-xl lg:max-w-2xl mx-4">
    <div class="w-full flex rounded-full overflow-hidden bg-white border border-[#e6e8e6] focus-within:border-[#9acd32] focus-within:shadow-[0_0_0_3px_rgba(154,205,50,0.10)] transition-all h-11">
        <span class="grid place-items-center pl-4 text-[#9aa19c]">
            <i class="fa-solid fa-magnifying-glass text-[20px]" style=""></i>
        </span>
        <input type="text" readonly placeholder="What are you looking for?"
               @click="$dispatch('open-search')"
               class="w-full h-full bg-transparent text-[13px] outline-none px-2 text-[#1c201e] placeholder:text-[#9aa19c] cursor-pointer">
        <button class="h-full px-5 bg-[#9acd32] text-white text-sm font-bold hover:bg-[#7ca81d] transition-colors flex items-center gap-1.5" @click="$dispatch('open-search')">
            <i class="fa-solid fa-magnifying-glass text-[18px]" style=""></i>
            <span class="hidden lg:inline">Search</span>
        </button>
    </div>
</div>
@endsection

@section('content')
<div x-data="rentalPage()">

    {{-- ============ MOBILE: rental card ============ --}}
    <section class="lg:hidden max-w-7xl mx-auto px-2 sm:px-6 pt-3">
        <div class="rounded-2xl bg-white border border-[#e8eae8] overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,0.04)]">

            {{-- image (slide-track) --}}
            <div class="relative h-64 sm:h-80 bg-[#f5f6f5] overflow-hidden">
                @if(count($rentalImages) > 0)
                <div class="flex h-full transition-transform duration-500 ease-out"
                     :style="'transform: translateX(-' + (imageIndex * 100) + '%)'">
                    @foreach($rentalImages as $i => $imgUrl)
                    <img src="{{ $imgUrl }}" alt="{{ $rental->name }} {{ $i + 1 }}" class="w-full h-full shrink-0 object-cover select-none">
                    @endforeach
                </div>
                <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2 py-1 rounded-full bg-black/60 text-white text-[10px] font-bold tnum backdrop-blur-sm">
                    <span x-text="imageIndex + 1"></span>/{{ count($rentalImages) }}
                </span>
                @if(count($rentalImages) > 1)
                <button @click="prev()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/95 shadow-md grid place-items-center text-[#1c201e] hover:scale-105 transition-transform active:scale-95"
                        aria-label="Previous image">
                    <i class="fa-solid fa-chevron-left text-[15px]" style=""></i>
                </button>
                <button @click="next()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/95 shadow-md grid place-items-center text-[#1c201e] hover:scale-105 transition-transform active:scale-95"
                        aria-label="Next image">
                    <i class="fa-solid fa-chevron-right text-[15px]" style=""></i>
                </button>
                @endif
                @else
                <div class="w-full h-full flex items-center justify-center text-[#c6cac6]">
                    <i class="fa-solid fa-image text-[56px]"></i>
                </div>
                @endif
                <span class="absolute top-3 left-3 -rotate-3 inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-[#1c201e]/85 text-white text-[10px] font-bold backdrop-blur-sm shadow-sm border border-white/10">
                    <i class="fa-solid fa-tag text-[9px] text-[#9acd32]" style=""></i>
                    {{ $rental->category?->name ?? 'Rental' }}
                </span>
            </div>
            @if(count($rentalImages) > 1)
            <div class="flex gap-2 pt-3 px-4 pb-1 overflow-x-auto no-scrollbar">
                @foreach($rentalImages as $i => $imgUrl)
                <button @click="go({{ $i }})"
                        class="shrink-0 w-14 h-14 rounded-xl overflow-hidden border-2 transition-all duration-300"
                        :class="imageIndex === {{ $i }} ? 'border-[#9acd32] ring-2 ring-[#9acd32]/30' : 'border-transparent hover:border-[#c6cac6]'">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover" loading="lazy" alt="Thumbnail {{ $i + 1 }}">
                </button>
                @endforeach
            </div>
            @endif

            {{-- info --}}
            <div class="p-4 sm:p-5 pt-3">
                {{-- badges --}}
                <div class="flex items-center gap-1.5 flex-wrap mb-2">
                    @if($store->is_verified)
                    <span class="inline-flex items-center text-[9px] font-black uppercase tracking-wide text-[#659316]">
                        <i class="fa-solid fa-circle-check text-[11px] mr-0.5" style=""></i> Verified seller
                    </span>
                    @endif
                    @if($rental->category)
                    <span class="text-[9px] font-bold uppercase tracking-wide text-[#6b716c] bg-[#f5f6f5] px-1.5 py-0.5 rounded-full">{{ $rental->category->name }}</span>
                    @endif
                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full bg-[#f2f9df] text-[#659316] text-[9px] font-bold uppercase tracking-wide border border-[#9acd32]/25">
                        <i class="fa-solid fa-calendar-days text-[10px]" style=""></i> {{ ucfirst($rental->billing_unit) }}
                    </span>
                </div>

                <h1 class="text-[19px] sm:text-[22px] font-bold leading-snug text-[#1c201e]">{{ $rental->name }}</h1>

                {{-- store + rating + views --}}
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1.5">
                    <a href="{{ route('stores.show', $store->slug) }}" class="text-[11px] font-semibold text-[#659316]">
                        <i class="fa-solid fa-store text-[11px] mr-0.5" style=""></i>{{ $store->name }}
                    </a>
                    @if($totalReviews > 0)
                    <span class="inline-flex items-center gap-1 text-[11px] text-[#6b716c]">
                        <i class="fa-solid fa-star text-[11px] text-amber-400" style=""></i>
                        <strong class="text-[#1c201e] tnum">{{ number_format($avgRating, 1) }}</strong>
                        <span class="text-[#9aa19c]">({{ $totalReviews }})</span>
                    </span>
                    @endif
                    @if($rental->location)
                    <span class="inline-flex items-center gap-1 text-[11px] text-[#9aa19c]">
                        <i class="fa-solid fa-location-dot text-[11px]" style=""></i>
                        <span class="truncate">{{ $rental->location }}</span>
                    </span>
                    @endif
                    <span class="inline-flex items-center gap-1 text-[11px] text-[#9aa19c]">
                        <i class="fa-regular fa-eye text-[11px]" style=""></i>
                        <span class="tnum">{{ number_format($rental->views ?? 0) }}</span>
                    </span>
                </div>

                {{-- price --}}
                <div class="mt-3 pb-1">
                    <div class="flex items-end gap-2 flex-wrap">
                        <span class="text-[22px] sm:text-[26px] font-black text-[#1c201e] tnum tracking-tight">{{ number_format((float) $rental->rate) }} <span class="text-[12px] font-bold text-[#6b716c]">FCFA</span></span>
                        <span class="text-[11px] font-semibold text-[#659316] mb-1"><i class="fa-solid fa-calendar-days text-[11px]" style=""></i> / {{ $rental->billing_unit }}</span>
                    </div>
                    @if($rental->deposit)
                    <p class="mt-1 text-[11px] font-semibold text-[#6b716c]">
                        <i class="fa-solid fa-shield-halved text-[12px] text-[#9aa19c]" style=""></i>
                        Deposit: <strong class="text-[#1c201e] tnum">{{ number_format((float) $rental->deposit) }} FCFA</strong>
                    </p>
                    @endif
                </div>

                @if($rental->serial_number)
                <p class="mt-1.5 flex items-center gap-1.5 text-[11px] text-[#9aa19c]">
                    <i class="fa-solid fa-qrcode text-[12px]" style=""></i>
                    Serial: <strong class="text-[#6b716c]">{{ $rental->serial_number }}</strong>
                </p>
                @endif

                {{-- condition notes --}}
                @if($rental->condition_notes)
                <div class="mt-3 bg-[#fffbeb] border border-[#f3e2b8] rounded-xl px-3 py-2.5 flex items-start gap-2">
                    <i class="fa-solid fa-circle-info text-[14px] text-[#f59e0b] mt-0.5 shrink-0" style=""></i>
                    <p class="text-[11px] text-[#92600a] leading-relaxed">{{ $rental->condition_notes }}</p>
                </div>
                @endif

                {{-- CTA --}}
                <div class="mt-4">
                    @auth
                        @if(auth()->id() === $store->user_id)
                        <div class="flex items-center gap-2 text-[12px] font-semibold text-[#659316] bg-[#f2f9df] border border-[#9acd32]/25 rounded-xl px-4 py-3">
                            <i class="fa-regular fa-circle-check text-[16px]" style=""></i>
                            This is your own rental.
                        </div>
                        @else
                        <form action="{{ route('conversations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                            <input type="hidden" name="target_type" value="rental">
                            <input type="hidden" name="target_id" value="{{ $rental->id }}">
                            <input type="hidden" name="message" value="Hi, I'm interested in renting {{ $rental->name }}. Is it available?">
                            <button type="submit"
                                    class="w-full h-12 bg-[#1c201e] text-white text-[12.5px] font-bold rounded-xl hover:bg-black active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                                <i class="fa-regular fa-comment text-[15px]" style=""></i>
                                Message seller
                            </button>
                        </form>
                        @if($store->whatsapp_number)
                        <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I\'m interested in renting ' . $rental->name . ' on Izifai.') }}"
                           target="_blank"
                           class="mt-2 w-full h-12 bg-[#25D366] text-white text-[12.5px] font-bold rounded-xl hover:bg-[#128C7E] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                            {!! str_replace('w-5 h-5', 'w-[18px] h-[18px]', $whatsappIcon) !!}
                            Chat on WhatsApp
                        </a>
                        @endif
                        @endif
                    @else
                        @if($store->whatsapp_number)
                        <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I\'m interested in renting ' . $rental->name . ' on Izifai.') }}"
                           target="_blank"
                           class="w-full h-12 bg-[#25D366] text-white text-[12.5px] font-bold rounded-xl hover:bg-[#128C7E] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                            {!! str_replace('w-5 h-5', 'w-[18px] h-[18px]', $whatsappIcon) !!}
                            Chat on WhatsApp
                        </a>
                        @endif
                    @endauth

                    <button onclick="copyToClipboard(window.location.href, this)"
                            class="mt-2 w-full h-10 rounded-xl border border-[#e8eae8] text-[#3f453f] text-[11.5px] font-semibold hover:bg-[#f5f6f5] transition-colors flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-share-nodes text-[13px]" style=""></i>
                        Share link
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ DESKTOP: breadcrumb + gallery + info ============ --}}
    <section class="hidden lg:block max-w-7xl mx-auto px-2 sm:px-6 pt-8">
        <div class="flex items-center gap-1.5 text-[12px] text-[#9aa19c] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#659316] transition-colors">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-[#c6cac6]" style=""></i>
            <a href="{{ route('rentals.index') }}" class="hover:text-[#659316] transition-colors">Rentals</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-[#c6cac6]" style=""></i>
            <span class="text-[#1c201e] font-semibold truncate">{{ $rental->name }}</span>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">
            {{-- gallery --}}
            <div class="col-span-7">
                <div class="relative bg-white rounded-2xl border border-[#e8eae8] overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
                    @if(count($rentalImages) > 0)
                    <div class="flex transition-transform duration-500 ease-out"
                         :style="'transform: translateX(-' + (imageIndex * 100) + '%)'">
                        @foreach($rentalImages as $i => $imgUrl)
                        <img src="{{ $imgUrl }}" alt="{{ $rental->name }} {{ $i + 1 }}" class="w-full h-[440px] lg:h-[520px] object-cover shrink-0 select-none">
                        @endforeach
                    </div>
                    @else
                    <div class="w-full h-[440px] lg:h-[520px] flex items-center justify-center text-[#c6cac6]">
                        <i class="fa-solid fa-image text-[72px]"></i>
                    </div>
                    @endif
                    <button onclick="copyToClipboard(window.location.href, this)"
                            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 shadow-sm grid place-items-center text-[#3f453f] hover:text-[#1c201e] border border-[#e8eae8] hover:scale-105 transition-all">
                        <i class="fa-solid fa-share-nodes text-[15px] copy-icon" style=""></i>
                    </button>
                    @if(count($rentalImages) > 1)
                    <span class="absolute bottom-4 right-4 px-2 py-1 rounded-full bg-black/60 backdrop-blur-sm text-white text-[11px] font-bold tnum">
                        <span x-text="imageIndex + 1"></span>/{{ count($rentalImages) }}
                    </span>
                    @endif
                    <span class="absolute bottom-4 left-4 -rotate-3 inline-flex items-center gap-1 px-3 py-1 rounded-md bg-[#1c201e]/85 text-white text-[11px] font-bold backdrop-blur-sm shadow-sm border border-white/10">
                        <i class="fa-solid fa-tag text-[10px] text-[#9acd32]" style=""></i>
                        {{ $rental->category?->name ?? 'Rental' }}
                    </span>
                </div>
                @if(count($rentalImages) > 1)
                <div class="flex gap-3 mt-3">
                    @foreach($rentalImages as $i => $imgUrl)
                    <button @click="go({{ $i }})"
                            class="w-16 h-16 rounded-xl overflow-hidden border-2 transition-all"
                            :class="imageIndex === {{ $i }} ? 'border-[#9acd32]' : 'border-transparent hover:border-[#c6cac6]'">
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover" loading="lazy">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- info --}}
            <div class="col-span-5">
                <div class="sticky top-[100px] bg-white rounded-2xl border border-[#e8eae8] p-6 shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
                    <div class="flex items-center gap-2 flex-wrap mb-2">
                        @if($store->is_verified)
                        <span class="inline-flex items-center text-[10px] font-black uppercase tracking-wide text-[#659316]">
                            <i class="fa-solid fa-circle-check text-[12px] mr-0.5" style=""></i> Verified seller
                        </span>
                        @endif
                        @if($rental->category)
                        <span class="text-[10px] font-bold uppercase tracking-wide text-[#6b716c] bg-[#f5f6f5] px-2 py-0.5 rounded-full">{{ $rental->category->name }}</span>
                        @endif
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#f2f9df] text-[#659316] text-[10px] font-bold uppercase tracking-wide border border-[#9acd32]/25">
                            <i class="fa-solid fa-calendar-days text-[11px]" style=""></i> {{ ucfirst($rental->billing_unit) }}
                        </span>
                    </div>

                    <h1 class="text-[22px] font-bold leading-snug text-[#1c201e]">{{ $rental->name }}</h1>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-2 text-[12.5px]">
                        <a href="{{ route('stores.show', $store->slug) }}" class="font-semibold text-[#659316] hover:underline">
                            <i class="fa-solid fa-store text-[12px] mr-0.5" style=""></i>{{ $store->name }}
                        </a>
                        @if($totalReviews > 0)
                        <span class="inline-flex items-center gap-1 text-[#6b716c]">
                            <i class="fa-solid fa-star text-[12px] text-amber-400" style=""></i>
                            <strong class="text-[#1c201e] tnum">{{ number_format($avgRating, 1) }}</strong>
                            <span class="text-[#9aa19c]">({{ $totalReviews }} reviews)</span>
                        </span>
                        @endif
                        @if($rental->location)
                        <span class="inline-flex items-center gap-1 text-[#9aa19c]">
                            <i class="fa-solid fa-location-dot text-[12px]" style=""></i>
                            <span class="truncate">{{ $rental->location }}</span>
                        </span>
                        @endif
                        <span class="inline-flex items-center gap-1 text-[#9aa19c]">
                            <i class="fa-regular fa-eye text-[13px]" style=""></i>
                            <span class="tnum">{{ number_format($rental->views ?? 0) }}</span>
                        </span>
                    </div>

                    <div class="mt-4 pb-4 border-b border-[#f2f3f2]">
                        <div class="flex flex-wrap items-end gap-x-2.5 gap-y-1">
                            <span class="text-[26px] font-black text-[#1c201e] tnum tracking-tight">{{ number_format((float) $rental->rate) }} <span class="text-[13px] font-bold text-[#6b716c]">FCFA</span></span>
                            <span class="text-[12px] font-bold text-[#659316] mb-1"><i class="fa-solid fa-calendar-days text-[12px]" style=""></i> / {{ $rental->billing_unit }}</span>
                        </div>
                        @if($rental->deposit)
                        <p class="mt-1.5 text-[12px] font-semibold text-[#6b716c]">
                            <i class="fa-solid fa-shield-halved text-[13px] text-[#9aa19c]" style=""></i>
                            Deposit: <strong class="text-[#1c201e] tnum">{{ number_format((float) $rental->deposit) }} FCFA</strong>
                        </p>
                        @endif
                    </div>

                    @if($rental->serial_number)
                    <p class="mt-3 flex items-center gap-1.5 text-[12px] text-[#9aa19c]">
                        <i class="fa-solid fa-qrcode text-[13px]" style=""></i>
                        Serial: <strong class="text-[#6b716c]">{{ $rental->serial_number }}</strong>
                    </p>
                    @endif

                    @if($rental->condition_notes)
                    <div class="mt-3 bg-[#fffbeb] border border-[#f3e2b8] rounded-xl px-3.5 py-3 flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-[15px] text-[#f59e0b] mt-0.5 shrink-0" style=""></i>
                        <p class="text-[12px] text-[#92600a] leading-relaxed">{{ $rental->condition_notes }}</p>
                    </div>
                    @endif

                    <div class="mt-5">
                        @auth
                            @if(auth()->id() === $store->user_id)
                            <div class="flex items-center gap-2 text-[12px] font-semibold text-[#659316] bg-[#f2f9df] border border-[#9acd32]/25 rounded-xl px-4 py-3">
                                <i class="fa-regular fa-circle-check text-[16px]" style=""></i>
                                This is your own rental.
                            </div>
                            @else
                            <form action="{{ route('conversations.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                                <input type="hidden" name="target_type" value="rental">
                                <input type="hidden" name="target_id" value="{{ $rental->id }}">
                                <input type="hidden" name="message" value="Hi, I'm interested in renting {{ $rental->name }}. Is it available?">
                                <button type="submit"
                                        class="w-full h-12 bg-[#1c201e] text-white text-[13px] font-bold rounded-xl hover:bg-black active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                                    <i class="fa-regular fa-comment text-[16px]" style=""></i>
                                    Message seller
                                </button>
                            </form>
                            @if($store->whatsapp_number)
                            <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I\'m interested in renting ' . $rental->name . ' on Izifai.') }}"
                               target="_blank"
                               class="mt-2 w-full h-12 bg-[#25D366] text-white text-[13px] font-bold rounded-xl hover:bg-[#128C7E] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                                {!! str_replace('w-5 h-5', 'w-[18px] h-[18px]', $whatsappIcon) !!}
                                Chat on WhatsApp
                            </a>
                            @endif
                            @endif
                        @else
                            @if($store->whatsapp_number)
                            <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I\'m interested in renting ' . $rental->name . ' on Izifai.') }}"
                               target="_blank"
                               class="w-full h-12 bg-[#25D366] text-white text-[13px] font-bold rounded-xl hover:bg-[#128C7E] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                                {!! str_replace('w-5 h-5', 'w-[18px] h-[18px]', $whatsappIcon) !!}
                                Chat on WhatsApp
                            </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ ABOUT ============ --}}
    @if($rental->description)
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-6">
        <div class="rounded-2xl bg-white border border-[#e8eae8] p-4 sm:p-6">
            <h2 class="text-[15px] sm:text-base font-bold text-[#1c201e] mb-2.5">About this rental</h2>
            <div class="text-[12.5px] sm:text-[13.5px] text-[#3f453f] leading-relaxed whitespace-pre-wrap break-words">{{ $rental->description }}</div>
        </div>
    </section>
    @endif

    {{-- ============ RENTAL TERMS ============ --}}
    @if($rental->return_conditions || $rental->duration_rules)
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-3">
        <h2 class="text-[14px] sm:text-base font-bold text-[#1c201e] mb-2.5 px-0.5">Rental terms</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @if($rental->return_conditions)
            <div class="rounded-2xl bg-white border border-[#e8eae8] p-4 sm:p-6">
                <h3 class="flex items-center gap-2 text-[13px] font-bold text-[#1c201e] mb-2">
                    <i class="fa-solid fa-clipboard-check text-[14px] text-[#659316]" style=""></i>
                    Return conditions
                </h3>
                <p class="text-[12px] sm:text-[13px] text-[#3f453f] leading-relaxed whitespace-pre-wrap">{{ $rental->return_conditions }}</p>
            </div>
            @endif
            @if($rental->duration_rules)
            <div class="rounded-2xl bg-white border border-[#e8eae8] p-4 sm:p-6">
                <h3 class="flex items-center gap-2 text-[13px] font-bold text-[#1c201e] mb-2">
                    <i class="fa-solid fa-clock text-[14px] text-[#659316]" style=""></i>
                    Duration rules
                </h3>
                <p class="text-[12px] sm:text-[13px] text-[#3f453f] leading-relaxed whitespace-pre-wrap">{{ $rental->duration_rules }}</p>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ============ SELLER ============ --}}
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-3">
        <div class="rounded-2xl bg-white border border-[#e8eae8] p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
            @if($store->logo_url)
            <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-14 h-14 rounded-xl object-cover border border-[#e8eae8] bg-[#f5f6f5] shrink-0">
            @else
            <div class="w-14 h-14 rounded-xl bg-[#f2f9df] border border-[#9acd32]/25 grid place-items-center text-[#659316] shrink-0">
                <i class="fa-solid fa-store text-[22px]" style=""></i>
            </div>
            @endif
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1.5 flex-wrap">
                    <p class="text-[14px] sm:text-[15px] font-bold text-[#1c201e] truncate">{{ $store->name }}</p>
                    @if($store->is_verified)
                    <i class="fa-solid fa-circle-check text-[15px] text-[#659316]" style=""></i>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-1 text-[11.5px] text-[#6b716c]">
                    @if($store->location)
                    <span><i class="fa-solid fa-location-dot text-[11px]" style=""></i> {{ $store->location }}</span>
                    @endif
                    <span>{{ $totalRentals }} rental{{ $totalRentals === 1 ? '' : 's' }}</span>
                    @if($store->business_email)
                    <span class="truncate">{{ $store->business_email }}</span>
                    @endif
                </div>
            </div>
            <a href="{{ route('stores.show', $store->slug) }}"
               class="shrink-0 h-11 px-5 rounded-xl bg-[#1c201e] text-white text-[12px] font-bold hover:bg-black transition-colors flex items-center justify-center gap-1.5">
                Visit store
                <i class="fa-solid fa-arrow-right text-[14px]" style=""></i>
            </a>
        </div>
        <p class="mt-2 px-1 text-[11px] text-[#9aa19c]">
            <i class="fa-regular fa-shield-check text-[12px] mr-1 text-[#659316]" style=""></i>
            Inspect the item before paying · Read the rental terms carefully · Return it in the same condition.
        </p>
    </section>

    {{-- ============ REVIEWS ============ --}}
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-3">
        <div class="rounded-2xl bg-white border border-[#e8eae8] p-4 sm:p-6">
            <div class="flex flex-col lg:flex-row lg:items-start lg:gap-8">
                <div class="lg:w-56 lg:text-center shrink-0 flex items-center lg:block gap-4 lg:gap-0">
                    <div>
                        <span class="text-[36px] sm:text-[44px] font-black text-[#1c201e] tnum leading-none">{{ number_format($avgRating, 1) }}</span>
                        <div class="flex items-center gap-0.5 mt-1.5 justify-start lg:justify-center">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star text-[14px] {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-[#e0e3e0]' }}" style=""></i>
                            @endfor
                        </div>
                        <p class="text-[11px] text-[#9aa19c] mt-1">{{ $totalReviews }} review{{ $totalReviews === 1 ? '' : 's' }}</p>
                    </div>
                    @if($totalReviews > 0)
                    <div class="lg:mt-5 space-y-1.5 w-full max-w-[180px] lg:mx-auto">
                        @foreach([5, 4, 3, 2, 1] as $star)
                        @php $count = $starDistribution[$star]['count'] ?? 0; $pct = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0; @endphp
                        <div class="flex items-center gap-2">
                            <span class="w-4 text-[10px] font-bold text-[#9aa19c] tnum shrink-0">{{ $star }}</span>
                            <div class="flex-1 h-1.5 bg-[#eef0ee] rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-[#7ca81d] to-[#9acd32]" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="w-5 text-right text-[10px] text-[#9aa19c] font-semibold tnum shrink-0">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="flex-1 min-w-0 mt-5 lg:mt-0">
                    @auth
                    @if(auth()->id() !== $store->user_id)
                    <div class="lg:max-w-[480px] px-0 lg:pr-10">
                        <p class="text-[12px] font-bold text-[#1c201e] mb-2">Share your thoughts</p>
                        <div class="flex items-center gap-1 mb-2">
                            <template x-for="i in 5" :key="i">
                                <button type="button" @mouseenter="reviewHover = i" @mouseleave="reviewHover = 0" @click="reviewStar = i" class="text-[22px] leading-none">
                                    <i class="fa-solid fa-star transition-colors" :class="(i <= (reviewHover || reviewStar)) ? 'text-amber-400' : 'text-[#e0e3e0]'"></i>
                                </button>
                            </template>
                            <span class="ml-1 text-[12px] font-semibold text-[#6b716c]" x-text="reviewStar ? reviewStar + '/5' : ''"></span>
                        </div>
                        <form action="{{ route('rentals.review', $rental) }}" method="POST" class="flex gap-2 items-end">
                            @csrf
                            <input type="hidden" name="rating" :value="reviewStar">
                            <textarea name="comment" rows="2" placeholder="How was your rental experience?"
                                      class="flex-1 rounded-xl border border-[#e8eae8] bg-[#f5f6f5] text-[12.5px] px-3 py-2 outline-none focus:border-[#9acd32] focus:ring-2 focus:ring-[#9acd32]/15 transition-all placeholder:text-[#9aa19c] resize-none"></textarea>
                            <button type="submit"
                                    class="shrink-0 h-[42px] px-4 rounded-xl bg-[#1c201e] text-white text-[12px] font-bold hover:bg-black transition-colors">Post</button>
                        </form>
                    </div>
                    <div class="h-px bg-[#eef0ee] my-5 lg:my-6"></div>
                    @endif
                    @else
                    <div class="lg:max-w-[480px] rounded-xl bg-[#f5f6f5] border border-dashed border-[#e0e3e0] px-4 py-3.5 flex items-center justify-between">
                        <p class="text-[12px] text-[#6b716c]">Sign in to review this rental</p>
                        <a href="{{ route('login') }}" class="text-[12px] font-black text-[#659316]">Log in →</a>
                    </div>
                    <div class="h-px bg-[#eef0ee] my-5"></div>
                    @endauth

                    @if($reviews->isNotEmpty())
                    <div class="max-h-[380px] lg:max-h-[420px] overflow-y-auto pr-1.5 reviews-scroll">
                        <div class="space-y-4">
                        @foreach($reviews as $review)
                        @php $rating = (int)round((float)($review->rating ?? 5)); @endphp
                        <div class="border border-[#eef0ee] rounded-xl p-3 sm:p-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#f2f9df] text-[#659316] grid place-items-center font-black text-[12px] uppercase shrink-0">
                                    {{ substr($review->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[12px] font-bold text-[#1c201e] truncate">{{ $review->user->name ?? 'User' }}</p>
                                    <div class="flex items-center gap-1.5">
                                        <span class="flex items-center gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star text-[10px] {{ $i <= $rating ? 'text-amber-400' : 'text-[#e0e3e0]' }}" style=""></i>
                                            @endfor
                                        </span>
                                        <span class="text-[10px] text-[#9aa19c]">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-[12.5px] text-[#3f453f] leading-relaxed">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ============ MORE FROM STORE ============ --}}
    @if($storeRentals->isNotEmpty())
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-3">
        <div class="flex items-end justify-between gap-3 mb-3">
            <div>
                <h2 class="text-[14px] sm:text-lg font-bold tracking-tight text-[#1c201e]">More from {{ $store->name }}</h2>
                <p class="text-[10.5px] sm:text-[12px] text-[#6b716c] mt-0.5">Other items you can rent from this seller</p>
            </div>
            <a href="{{ route('stores.show', $store->slug) }}" class="text-[11px] sm:text-[13px] font-bold text-[#659316] hover:text-[#7ca81d] whitespace-nowrap">View store →</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3">
            @foreach($storeRentals as $sr)
            <a href="{{ route('rentals.show', $sr->slug) }}"
               class="group rounded-xl bg-white border border-[#e8eae8] overflow-hidden hover:border-[#9acd32]/50 hover:shadow-[0_12px_30px_-12px_rgba(0,0,0,0.10)] transition-all duration-300">
                <div class="relative aspect-[4/3] bg-[#f5f6f5]">
                    @if($sr->main_image_url)
                    <img src="{{ $sr->main_image_url }}" alt="{{ $sr->name }}" loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.classList.add('hidden')">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-[#c6cac6]">
                        <i class="fa-solid fa-image text-[24px] sm:text-[28px]"></i>
                    </div>
                    @endif
                </div>
                <div class="p-2 sm:p-2.5">
                    <p class="text-[10px] sm:text-[12px] font-semibold text-[#1c201e] line-clamp-2 leading-snug">{{ $sr->name }}</p>
                    <p class="mt-0.5 text-[10.5px] sm:text-[12px] font-black text-[#659316] tnum">{{ number_format((float) $sr->rate) }} FCFA / {{ $sr->billing_unit }}</p>
                </div>
            </a>
            @endforeach
        </div>
</section>
    @endif

    {{-- ============ RELATED RENTALS ============ --}}
    @if($relatedRentals->isNotEmpty())
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-3">
        <div class="flex items-end justify-between gap-3 mb-3">
            <div>
                <h2 class="text-[14px] sm:text-lg font-bold tracking-tight text-[#1c201e]">Related rentals</h2>
                <p class="text-[10.5px] sm:text-[12px] text-[#6b716c] mt-0.5">More items you can rent on Izifai</p>
            </div>
            <a href="{{ route('rentals.index') }}" class="text-[11px] sm:text-[13px] font-bold text-[#659316] hover:text-[#7ca81d] whitespace-nowrap">View all →</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3">
            @foreach($relatedRentals as $rr)
            <a href="{{ route('rentals.show', $rr->slug) }}"
               class="group rounded-xl bg-white border border-[#e8eae8] overflow-hidden hover:border-[#9acd32]/50 hover:shadow-[0_12px_30px_-12px_rgba(0,0,0,0.10)] transition-all duration-300">
                <div class="relative aspect-[4/3] bg-[#f5f6f5]">
                    @if($rr->main_image_url)
                    <img src="{{ $rr->main_image_url }}" alt="{{ $rr->name }}" loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.classList.add('hidden')">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-[#c6cac6]">
                        <i class="fa-solid fa-image text-[24px] sm:text-[28px]"></i>
                    </div>
                    @endif
                </div>
                <div class="p-2 sm:p-2.5">
                    <p class="text-[10px] sm:text-[12px] font-semibold text-[#1c201e] line-clamp-2 leading-snug">{{ $rr->name }}</p>
                    <p class="mt-0.5 text-[10.5px] sm:text-[12px] font-black text-[#659316] tnum">{{ number_format((float) $rr->rate) }} FCFA / {{ $rr->billing_unit }}</p>
                    <p class="mt-0.5 flex items-center gap-0.5 text-[9.5px] sm:text-[10.5px] text-[#6b716c] truncate">
                        <i class="fa-solid fa-store text-[9px] sm:text-[10px]" style=""></i>{{ $rr->store->name }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection
@push('scripts')
<script>
    function rentalPage() {
        return {
            images: @json($rentalImages),
            imageIndex: 0,
            reviewStar: 0,
            reviewHover: 0,
            prev() { this.go(this.imageIndex - 1); },
            next() { this.go(this.imageIndex + 1); },
            go(i) {
                const total = this.images.length;
                if (total === 0) return;
                this.imageIndex = ((i % total) + total) % total;
            }
        };
    }
</script>
@endpush