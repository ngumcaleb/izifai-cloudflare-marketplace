@extends('layouts.guest')

@section('title', 'Izifai — Stop Sending Photos. Start Selling.')
@section('description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs. No app needed — just a link.')

@push('styles')
<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes pulse-warning {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
    .animate-fade-in { animation: fade-in 0.8s ease-out forwards; }
    .animate-pulse-warning { animation: pulse-warning 2s ease-in-out infinite; }
    .pain-card:nth-child(1) { animation-delay: 0.1s; }
    .pain-card:nth-child(2) { animation-delay: 0.2s; }
    .pain-card:nth-child(3) { animation-delay: 0.3s; }
    .text-balance { text-wrap: balance; }
</style>
@endpush

@section('content')

{{-- ===== HERO: THE PAIN ===== --}}
<section class="relative min-h-[90vh] flex items-center overflow-hidden bg-gradient-to-b from-surface via-surface to-surface">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-primary/[0.02] to-transparent"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 relative w-full pt-20 lg:pt-0">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-error/10 rounded-full text-xs font-bold text-error mb-6 tracking-wide border border-error/10">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">warning</span>
                The Problem
            </div>
            <h1 class="text-[32px] sm:text-[44px] lg:text-[56px] font-black leading-[1.05] tracking-tight text-on-surface text-balance">
                Posting the Same Products<br>
                in Your Group <span class="text-error">Again and Again?</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-on-surface-variant mt-4 max-w-xl mx-auto leading-relaxed">
                You post your products in WhatsApp groups. Same photos, every day. It eats your customers' data. It annoys them. <strong class="text-on-surface">So they archive your group and never see your products again.</strong> You're losing customers and you don't even know it.
            </p>

            {{-- Pain mini-cards --}}
            <div class="mt-10 grid sm:grid-cols-3 gap-3 max-w-2xl mx-auto">
                <div class="pain-card bg-error/5 rounded-xl px-4 py-3.5 border border-error/10 text-center opacity-0 animate-fade-in-up">
                    <span class="material-symbols-outlined text-error text-xl" style="font-variation-settings: 'FILL' 1;">campaign</span>
                    <p class="text-xs font-bold text-on-surface mt-1">Group Spam</p>
                    <p class="text-[10px] text-on-surface-variant mt-0.5">Same posts, day after day</p>
                </div>
                <div class="pain-card bg-error/5 rounded-xl px-4 py-3.5 border border-error/10 text-center opacity-0 animate-fade-in-up">
                    <span class="material-symbols-outlined text-error text-xl" style="font-variation-settings: 'FILL' 1;">signal_disconnected</span>
                    <p class="text-xs font-bold text-on-surface mt-1">Data Drain</p>
                    <p class="text-[10px] text-on-surface-variant mt-0.5">Eats members' bundles</p>
                </div>
                <div class="pain-card bg-error/5 rounded-xl px-4 py-3.5 border border-error/10 text-center opacity-0 animate-fade-in-up">
                    <span class="material-symbols-outlined text-error text-xl" style="font-variation-settings: 'FILL' 1;">archive</span>
                    <p class="text-xs font-bold text-on-surface mt-1">Archived & Ignored</p>
                    <p class="text-[10px] text-on-surface-variant mt-0.5">Group gets muted forever</p>
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary text-on-primary rounded-full text-sm font-bold shadow-lg shadow-primary/25 hover:scale-105 hover:shadow-xl transition-all active:scale-95">
                    Create Your Free Catalog
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>
                <a href="#solution"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-surface-container-lowest text-on-surface rounded-full text-sm font-bold border border-outline-variant/20 hover:border-primary/30 hover:shadow-md transition-all">
                    There's a Better Way
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== THE SCENE: SOUND FAMILIAR? ===== --}}
<section class="py-16 lg:py-24 bg-surface-container-low">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center mb-12 lg:mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-error/10 rounded-full text-xs font-bold text-error mb-4 tracking-wide">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">psychology</span>
                Sound Familiar?
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-on-surface text-balance">This Is What's Happening</h2>
            <p class="text-sm text-on-surface-variant mt-3">You might not notice it, but here's what your customers are really doing.</p>
        </div>

        {{-- The scenario --}}
        <div class="max-w-4xl mx-auto bg-surface-container-lowest rounded-2xl lg:rounded-3xl border border-outline-variant/10 shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-error/5 to-error/10 px-6 lg:px-10 py-6 border-b border-outline-variant/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-error-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-error text-[20px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-surface">Your WhatsApp Group</p>
                        <p class="text-[10px] text-on-surface-variant">2:30 PM • You just posted 6 product photos</p>
                    </div>
                    <div class="ml-auto flex items-center gap-1 text-on-surface-variant/40">
                        <span class="material-symbols-outlined text-[18px]">more_vert</span>
                    </div>
                </div>
            </div>
            {{-- Chat messages --}}
            <div class="p-6 lg:p-10 space-y-5">
                {{-- Your post --}}
                <div class="flex justify-start">
                    <div class="max-w-[85%] sm:max-w-[70%] bg-surface-container-high rounded-2xl rounded-bl-sm p-3.5">
                        <p class="text-[10px] font-semibold text-on-surface-variant mb-1.5">You — 2:30 PM</p>
                        <div class="grid grid-cols-3 gap-1.5 mb-2">
                            <div class="aspect-square bg-primary/10 rounded-lg flex items-center justify-center text-[16px]">👜</div>
                            <div class="aspect-square bg-primary/10 rounded-lg flex items-center justify-center text-[16px]">👗</div>
                            <div class="aspect-square bg-primary/10 rounded-lg flex items-center justify-center text-[16px]">👠</div>
                            <div class="aspect-square bg-primary/10 rounded-lg flex items-center justify-center text-[16px]">🧥</div>
                            <div class="aspect-square bg-primary/10 rounded-lg flex items-center justify-center text-[16px]">👔</div>
                            <div class="aspect-square bg-primary/10 rounded-lg flex items-center justify-center text-[16px]">👟</div>
                        </div>
                        <p class="text-xs text-on-surface">New arrivals! Check them out 🔥🔥</p>
                        <p class="text-[10px] text-on-surface-variant mt-1">DM for prices</p>
                    </div>
                </div>
                {{-- Member 1: annoyed --}}
                <div class="flex justify-end">
                    <div class="max-w-[85%] sm:max-w-[70%] bg-error/5 rounded-2xl rounded-br-sm p-3.5 border border-error/10">
                        <p class="text-[10px] font-semibold text-on-surface-variant mb-1">Sarah — 2:31 PM</p>
                        <p class="text-xs text-on-surface">Same products again? 😩</p>
                        <p class="text-xs text-on-surface-variant mt-1">My data is almost finished abeg</p>
                    </div>
                </div>
                {{-- Member 2: leaves --}}
                <div class="flex justify-end">
                    <div class="max-w-[85%] sm:max-w-[70%] bg-surface-container-high rounded-2xl rounded-br-sm p-3.5">
                        <p class="text-[10px] font-semibold text-on-surface-variant mb-1">John — 2:33 PM</p>
                        <p class="text-xs text-on-surface-variant">left the group</p>
                        <div class="flex items-center gap-2 mt-1.5 text-amber-600">
                            <span class="material-symbols-outlined text-[16px]">block</span>
                            <span class="text-[10px] font-semibold">Blocked group notifications</span>
                        </div>
                    </div>
                </div>
                {{-- Member 3: archives --}}
                <div class="flex justify-end">
                    <div class="max-w-[85%] sm:max-w-[70%] bg-surface-container-high rounded-2xl rounded-br-sm p-3.5">
                        <p class="text-[10px] font-semibold text-on-surface-variant mb-1">Blessing — 2:45 PM</p>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-amber-600 text-[18px]">archive</span>
                            <span class="text-xs text-on-surface-variant">Archived this group</span>
                        </div>
                        <p class="text-[10px] text-on-surface-variant mt-1">She will never see your products again.</p>
                    </div>
                </div>
            </div>
            {{-- Footer --}}
            <div class="px-6 lg:px-10 py-4 bg-surface-container-low border-t border-outline-variant/10">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-semibold text-on-surface-variant flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px] text-on-surface-variant/40">visibility_off</span>
                        Most members have muted this group
                    </p>
                    <span class="text-[10px] font-bold text-error animate-pulse-warning">1,280 views → 3 sales</span>
                </div>
            </div>
        </div>

        {{-- The hard truth --}}
        <div class="mt-10 max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-error/10 rounded-full text-xs font-bold text-error mb-4">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">heart_broken</span>
                The Hard Truth
            </div>
            <p class="text-base sm:text-lg text-on-surface leading-relaxed">
                Every time you post those same photos, people tune out. They archive your group. They mute notifications. <strong class="text-error">They stop buying from you — not because your products are bad, but because the way you sell is exhausting.</strong>
            </p>
        </div>
    </div>
</section>

{{-- ===== THE REAL COST ===== --}}
<section class="py-14 lg:py-20 bg-surface">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-error/10 rounded-full text-xs font-bold text-error mb-4 tracking-wide">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">calculating</span>
                What This Costs You
            </div>
            <div class="grid sm:grid-cols-3 gap-6 sm:gap-10 mt-8">
                <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/10">
                    <span class="material-symbols-outlined text-3xl text-error mb-2" style="font-variation-settings: 'FILL' 1;">groups_off</span>
                    <p class="text-2xl sm:text-3xl font-black text-error">73%</p>
                    <p class="text-[11px] text-on-surface-variant font-medium mt-1">of group members ignore repeated product posts¹</p>
                </div>
                <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/10">
                    <span class="material-symbols-outlined text-3xl text-error mb-2" style="font-variation-settings: 'FILL' 1;">archive</span>
                    <p class="text-2xl sm:text-3xl font-black text-error">2.5x</p>
                    <p class="text-[11px] text-on-surface-variant font-medium mt-1">more likely to archive a group than to leave it¹</p>
                </div>
                <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/10">
                    <span class="material-symbols-outlined text-3xl text-error mb-2" style="font-variation-settings: 'FILL' 1;">trending_down</span>
                    <p class="text-2xl sm:text-3xl font-black text-error">60%</p>
                    <p class="text-[11px] text-on-surface-variant font-medium mt-1">of potential buyers never message after seeing spammy posts¹</p>
                </div>
            </div>
            <p class="text-[10px] text-on-surface-variant mt-6 italic">¹ Based on surveys of Cameroon WhatsApp group members</p>
        </div>
    </div>
</section>

{{-- ===== THE SOLUTION ===== --}}
<section id="solution" class="py-16 lg:py-24 bg-surface-container-low overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 rounded-full text-xs font-bold text-primary mb-4 tracking-wide">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">auto_fix_high</span>
                The Solution
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-on-surface text-balance">One Link Changes Everything</h2>
            <p class="text-sm text-on-surface-variant mt-3">Instead of 10 photos, send 1 link. Your catalog does the rest.</p>
        </div>

        {{-- How it works in practice --}}
        <div class="max-w-4xl mx-auto bg-surface-container-lowest rounded-2xl lg:rounded-3xl border border-primary/20 shadow-lg shadow-primary/5 overflow-hidden mb-14 lg:mb-20">
            <div class="bg-gradient-to-r from-primary/5 to-primary/10 px-6 lg:px-10 py-6 border-b border-primary/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-surface">With Izifai — Same Group, Different Result</p>
                        <p class="text-[10px] text-on-surface-variant">Post once. Your catalog stays.</p>
                    </div>
                </div>
            </div>
            <div class="p-6 lg:p-10">
                <div class="flex justify-start">
                    <div class="max-w-[85%] sm:max-w-[70%] bg-primary/5 rounded-2xl rounded-bl-sm p-3.5 border border-primary/10">
                        <p class="text-[10px] font-semibold text-on-surface-variant mb-1.5">You — 2:30 PM</p>
                        <div class="bg-surface-container-lowest rounded-xl p-3 border border-outline-variant/10 mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-primary-container flex items-center justify-center text-[10px] font-black text-on-primary shrink-0">I</div>
                                <div>
                                    <p class="text-[11px] font-bold text-on-surface">My Store — Full Catalog</p>
                                    <p class="text-[9px] text-on-surface-variant">View all products with prices →</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-on-surface">Check out my full catalog! Everything is here with prices 🚀</p>
                        <div class="mt-2 inline-flex items-center gap-1.5 bg-primary/10 rounded-full px-3 py-1">
                            <span class="material-symbols-outlined text-primary text-[12px]" style="font-variation-settings: 'FILL' 1;">link</span>
                            <span class="text-[9px] font-bold text-primary">izifai.com/store/my-store</span>
                        </div>
                        <p class="text-[10px] text-on-surface-variant mt-1.5">Seen by 45 • 12 clicked the link • 5 ordered 🎉</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2 text-xs text-on-surface-variant bg-surface-container-low rounded-xl px-4 py-3">
                    <span class="material-symbols-outlined text-primary text-[16px]" style="font-variation-settings: 'FILL' 1;">public</span>
                    <span>Everyone sees your catalog. No data wasted. No spam. No archives.</span>
                </div>
            </div>
        </div>

        {{-- Before/After compact --}}
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8 max-w-4xl mx-auto mb-14 lg:mb-20">
            <div class="bg-surface rounded-2xl p-6 lg:p-8 border border-error/20 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-error/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-error text-[18px]" style="font-variation-settings: 'FILL' 1;">close</span>
                    </div>
                    <span class="text-xs font-bold text-error uppercase tracking-wider">The Old Way</span>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-error text-[16px]">close</span>
                        <span class="text-xs text-on-surface-variant">Post same photos daily</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-error text-[16px]">close</span>
                        <span class="text-xs text-on-surface-variant">Waste members' data</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-error text-[16px]">close</span>
                        <span class="text-xs text-on-surface-variant">Annoy → Archive → Forget</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-error text-[16px]">close</span>
                        <span class="text-xs text-on-surface-variant">Lose sales without knowing</span>
                    </div>
                </div>
            </div>
            <div class="bg-primary/5 rounded-2xl p-6 lg:p-8 border border-primary/20 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary/10 rounded-full blur-2xl"></div>
                <div class="flex items-center gap-2 mb-4 relative">
                    <div class="w-8 h-8 rounded-lg bg-primary/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings: 'FILL' 1;">check</span>
                    </div>
                    <span class="text-xs font-bold text-primary uppercase tracking-wider">With Izifai</span>
                </div>
                <div class="space-y-2.5 relative">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[16px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs font-semibold text-on-surface">Post one link, forever</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[16px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs font-semibold text-on-surface">Zero data per view</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[16px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs font-semibold text-on-surface">Members stay, browse, buy</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[16px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs font-semibold text-on-surface">Prices visible instantly</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Solution benefits --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
            <div class="group bg-surface-container-lowest rounded-2xl p-6 lg:p-8 border border-outline-variant/10 hover:shadow-lg hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 text-center">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">link</span>
                </div>
                <h3 class="text-sm font-bold text-on-surface">One Link</h3>
                <p class="text-xs text-on-surface-variant mt-2 leading-relaxed">Post it once in your group. New products? Just update your catalog. The link stays the same.</p>
            </div>
            <div class="group bg-surface-container-lowest rounded-2xl p-6 lg:p-8 border border-outline-variant/10 hover:shadow-lg hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 text-center">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">data_saver_off</span>
                </div>
                <h3 class="text-sm font-bold text-on-surface">Zero Data Waste</h3>
                <p class="text-xs text-on-surface-variant mt-2 leading-relaxed">Customers browse your catalog without downloading heavy images to their phone.</p>
            </div>
            <div class="group bg-surface-container-lowest rounded-2xl p-6 lg:p-8 border border-outline-variant/10 hover:shadow-lg hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 text-center">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">bolt</span>
                </div>
                <h3 class="text-sm font-bold text-on-surface">Real-Time Updates</h3>
                <p class="text-xs text-on-surface-variant mt-2 leading-relaxed">Add products, change prices, mark sold out — your group always sees the latest.</p>
            </div>
            <div class="group bg-surface-container-lowest rounded-2xl p-6 lg:p-8 border border-outline-variant/10 hover:shadow-lg hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 text-center">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                </div>
                <h3 class="text-sm font-bold text-on-surface">Happy Group</h3>
                <p class="text-xs text-on-surface-variant mt-2 leading-relaxed">No more spam. Members stay engaged. They actually look forward to your posts.</p>
            </div>
        </div>

        {{-- Catalog preview --}}
        @if($featuredProducts->count() > 0)
        <div class="mt-14 lg:mt-20 bg-surface-container-lowest rounded-2xl lg:rounded-3xl p-6 lg:p-10 border border-outline-variant/10 shadow-sm">
            <div class="text-center mb-8">
                <p class="text-xs font-bold text-primary uppercase tracking-wider">See what your catalog could look like</p>
                <p class="text-lg sm:text-xl font-black text-on-surface mt-1">A preview of Izifai</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 lg:gap-4 max-w-2xl mx-auto">
                @foreach($featuredProducts as $product)
                <div class="group/card rounded-xl overflow-hidden border border-outline-variant/10 hover:shadow-md transition-all duration-300">
                    <div class="aspect-square bg-surface-container-high overflow-hidden">
                        @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/40">
                                <span class="material-symbols-outlined text-3xl">image</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-2.5">
                        <p class="text-[10px] font-bold text-on-surface truncate">{{ $product->name }}</p>
                        <p class="text-[10px] font-black text-primary mt-0.5">{{ number_format($product->price) }} FCFA</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('stores.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-container text-on-primary-container rounded-full text-xs font-bold hover:opacity-90 transition-all">
                    Browse Real Stores on Izifai
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ===== FINAL CTA ===== --}}
<section class="py-16 lg:py-24 bg-surface">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 rounded-full text-xs font-bold text-primary mb-5 tracking-wide">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                Free to Start
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-[40px] font-black tracking-tight text-on-surface text-balance leading-[1.1]">
                Stop Annoying Your Group.<br>
                <span class="text-primary">Start Selling Smarter.</span>
            </h2>
            <p class="text-sm sm:text-base text-on-surface-variant mt-4 max-w-sm mx-auto leading-relaxed">
                Join hundreds of Cameroon vendors who've stopped spamming photos and started sharing catalogs.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 sm:gap-4">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 sm:py-4 bg-primary text-on-primary rounded-full text-sm font-bold shadow-lg shadow-primary/25 hover:scale-105 hover:shadow-xl transition-all active:scale-95">
                    Create My Free Catalog
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>
                <a href="{{ route('stores.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-surface-container-lowest text-on-surface rounded-full text-sm font-bold border border-outline-variant/20 hover:border-primary/30 hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-[18px]">storefront</span>
                    See Stores on Izifai
                </a>
            </div>
            <p class="text-xs text-on-surface-variant mt-5 flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                Trusted by {{ $verifiedStores }}+ verified sellers &bull; No credit card needed
            </p>
        </div>
    </div>
</section>

@endsection
