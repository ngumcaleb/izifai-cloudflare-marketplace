@extends('layouts.auth')

@section('title', 'Create Your Account — iziFaii')

@section('content')

    {{-- LEFT: VALUE PROPS (desktop only) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-primary flex-col justify-between p-10 xl:p-14 relative overflow-hidden min-h-screen">

        <div class="absolute top-[-120px] right-[-120px] w-80 h-80 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute bottom-[-80px] left-[-80px] w-96 h-96 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full bg-white/5 blur-3xl"></div>

        <a href="/" class="relative z-10">
            <x-application-logo class="h-10 w-auto brightness-0 invert" />
        </a>

        <div class="relative z-10 space-y-8 max-w-lg">
            <div>
                <h1 class="text-4xl xl:text-5xl font-black text-on-primary leading-[1.15] tracking-tight">
                    Empowering Cameroonian<br>
                    <span class="text-primary-fixed-dim">Merchants</span>
                </h1>
                <p class="text-base text-on-primary/80 mt-4 leading-relaxed">
                    Join hundreds of vendors who've transformed their business with a professional digital catalog.
                </p>
            </div>

            <div class="space-y-3">
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary-container text-[22px]" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-primary">Create your catalog in minutes</p>
                        <p class="text-xs text-on-primary/70 mt-0.5">Upload photos, set prices, and organize by category. No technical skills needed.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary-container text-[22px]" style="font-variation-settings: 'FILL' 1;">share</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-primary">Share your link on WhatsApp</p>
                        <p class="text-xs text-on-primary/70 mt-0.5">Your catalog works with a single link. Share it anywhere — no app download needed.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary-container text-[22px]" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-primary">Grow your sales</p>
                        <p class="text-xs text-on-primary/70 mt-0.5">See which products get the most views. Know what your customers want and stock smarter.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10">
            <img src="{{ \App\Models\Setting::get('register_merchant_image', 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600&q=80') }}"
                 alt="Cameroonian merchant"
                 class="w-full max-w-md rounded-2xl shadow-2xl object-cover h-48 xl:h-56">
        </div>

        <p class="relative z-10 text-xs text-on-primary/50">&copy; {{ date('Y') }} iziFaii. Simplify Your Shopping.</p>
    </div>

    {{-- RIGHT: FORM PANEL --}}
    <div class="flex-1 flex flex-col min-h-dvh lg:min-h-screen bg-surface-container-lowest lg:bg-surface-container-lowest">

        {{-- Mobile: Hero with background --}}
        <div class="lg:hidden relative overflow-hidden bg-gradient-to-br from-[#00210d] via-[#003317] to-[#005228] px-6 pt-5 pb-8">
            <div class="absolute top-[-60px] right-[-60px] w-40 h-40 rounded-full bg-white/5 blur-2xl"></div>
            <div class="absolute bottom-[-40px] left-[-40px] w-48 h-48 rounded-full bg-white/5 blur-2xl"></div>
            <a href="/" class="relative z-10 inline-block mb-5">
                <x-application-logo class="h-7 w-auto brightness-0 invert" />
            </a>
            <div class="relative z-10 flex items-center gap-3">
                <span class="text-3xl leading-none">🇨🇲</span>
                <div>
                    <p class="text-sm font-bold text-white">Start Selling on Izifai</p>
                    <p class="text-xs text-white/70">Join hundreds of Cameroonian merchants. Create your catalog in 2 minutes — free and secure.</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center px-5 py-6 lg:py-0">
            <div class="w-full max-w-md">

                <div class="hidden lg:block mb-8">
                    <h1 class="text-2xl font-black text-on-surface tracking-tight">Create your account</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Start building your business today. It is free and secure.</p>
                </div>

        <div class="flex-1 flex items-center justify-center px-5 py-10 lg:py-0">
            <div class="w-full max-w-md">

                <div class="mb-8">
                    <h1 class="text-2xl font-black text-on-surface tracking-tight">Create your account</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Start building your business today. It's free and secure.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ showPassword: false, agree: false, countryCode: '237', countryFlag: '🇨🇲', countryOpen: false }">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Full Name</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">person</span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="Your full name">
                        </div>
                        @error('name') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Email Address</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">mail</span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="your@email.com">
                        </div>
                        @error('email') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">
                            Phone Number
                            <span class="text-[10px] font-medium text-on-surface-variant/60 normal-case">(WhatsApp)</span>
                        </label>
                        <div class="flex">
                            <div class="relative shrink-0">
                                <button type="button" @click="countryOpen = !countryOpen"
                                        class="flex items-center gap-1.5 px-3.5 py-3 bg-surface-container border border-outline-variant/50 border-r-0 rounded-l-lg text-sm font-medium text-on-surface hover:bg-surface-container-higher transition-colors whitespace-nowrap">
                                    <span class="text-base leading-none" x-text="countryFlag"></span>
                                    <span x-text="'+' + countryCode"></span>
                                    <svg class="w-3.5 h-3.5 text-on-surface-variant" :class="countryOpen && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="countryOpen" @click.away="countryOpen = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute top-full left-0 mt-1 w-44 bg-white rounded-lg shadow-lg border border-outline-variant/30 z-50 overflow-hidden">
                                    <button type="button" @click="countryCode='237'; countryFlag='🇨🇲'; countryOpen=false"
                                            class="flex items-center gap-2.5 w-full px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-primary/5 hover:text-primary transition-colors"
                                            :class="countryCode === '237' && 'bg-primary/10 text-primary'">
                                        <span class="text-base">🇨🇲</span>
                                        <span>Cameroon</span>
                                        <span class="ml-auto text-slate-400">+237</span>
                                    </button>
                                    <button type="button" @click="countryCode='234'; countryFlag='🇳🇬'; countryOpen=false"
                                            class="flex items-center gap-2.5 w-full px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-primary/5 hover:text-primary transition-colors"
                                            :class="countryCode === '234' && 'bg-primary/10 text-primary'">
                                        <span class="text-base">🇳🇬</span>
                                        <span>Nigeria</span>
                                        <span class="ml-auto text-slate-400">+234</span>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="country_code" x-model="countryCode">
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                   class="flex-1 min-w-0 pl-3 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-r-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   :placeholder="countryCode === '237' ? '6XX XXX XXX' : '8XX XXX XXXX'">
                        </div>
                        @error('phone') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">lock</span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                   class="w-full pl-11 pr-11 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="Min 8 characters">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                        @error('password') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Confirm Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">lock</span>
                            <input type="password" name="password_confirmation" required
                                   class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="Repeat password">
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="terms" x-model="agree" required
                               class="mt-0.5 w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary/20 cursor-pointer">
                        <label for="terms" class="text-xs text-on-surface-variant leading-relaxed cursor-pointer select-none">
                            I agree to the
                            <a href="#" class="text-primary font-bold hover:underline">Merchant Agreement</a>
                            and
                            <a href="#" class="text-primary font-bold hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" :disabled="!agree"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-on-primary rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                        Create My Account
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-on-surface-variant">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Log In</a>
                    </p>
                </div>

                <div class="mt-6 pt-5 border-t border-outline-variant/20 flex items-center justify-center gap-6">
                    <div class="flex items-center gap-1.5 text-xs text-on-surface-variant/60">
                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                        Secure Data
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-on-surface-variant/60">
                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">support_agent</span>
                        Local Support
                    </div>
                </div>

            </div>
        </div>

    </div>

    <p class="hidden lg:block fixed bottom-4 right-4 text-xs text-on-surface-variant/50 z-10">
        &copy; {{ date('Y') }} iziFaii &mdash; Cameroon
    </p>

@endsection