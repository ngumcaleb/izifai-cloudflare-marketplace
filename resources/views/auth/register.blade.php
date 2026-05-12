<x-guest-layout>
    <div x-data="{ role: '{{ old('role', 'buyer') }}' }">

        {{-- Heading --}}
        <div class="mb-7">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Join Izifai</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Create your account to start trading in Cameroon.</p>
        </div>

        {{-- Role Toggle --}}
        <div class="flex p-1.5 bg-slate-100 rounded-2xl mb-6 gap-1">
            <button type="button" @click="role = 'buyer'"
                    :class="role === 'buyer' ? 'bg-white text-brand shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                    class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all">
                <i class="fa-solid fa-bag-shopping"></i> Buyer
            </button>
            <button type="button" @click="role = 'seller'"
                    :class="role === 'seller' ? 'bg-white text-brand shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                    class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all">
                <i class="fa-solid fa-shop"></i> Seller / Vendor
            </button>
        </div>

        {{-- Seller hint --}}
        <div x-show="role === 'seller'" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mb-5 p-4 bg-brand/5 border border-brand/20 rounded-xl flex items-start gap-3">
            <i class="fa-solid fa-circle-info text-brand mt-0.5 shrink-0"></i>
            <p class="text-[12px] font-semibold text-brand leading-relaxed">
                A free store page will be created for you. You can list products immediately after registering.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="role" :value="role">

            {{-- Name --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Full Name</label>
                <div class="relative">
                    <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400 placeholder:font-normal"
                           placeholder="Your full name">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-500 font-semibold" />
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Email Address</label>
                <div class="relative">
                    <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400 placeholder:font-normal"
                           placeholder="your@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500 font-semibold" />
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Phone Number</label>
                <div class="relative flex">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-bold pointer-events-none">+237</span>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="w-full pl-16 pr-4 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400 placeholder:font-normal"
                           placeholder="6XX XXX XXX">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-1.5 text-xs text-red-500 font-semibold" />
            </div>

            {{-- Shop Name (sellers only) --}}
            <div x-show="role === 'seller'" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Business / Shop Name</label>
                <div class="relative">
                    <i class="fa-solid fa-store absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="text" name="store_name" value="{{ old('store_name') }}" :required="role === 'seller'"
                           class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400 placeholder:font-normal"
                           placeholder="e.g. Grace Electronics">
                </div>
                <x-input-error :messages="$errors->get('store_name')" class="mt-1.5 text-xs text-red-500 font-semibold" />
            </div>

            {{-- Password --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password" required
                               class="w-full pr-10 pl-4 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400"
                               placeholder="Min 8 chars">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                            <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Confirm</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400"
                           placeholder="Repeat">
                </div>
                <x-input-error :messages="$errors->get('password')" class="col-span-full text-xs text-red-500 font-semibold" />
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-brand text-white py-4 rounded-xl font-black text-sm uppercase tracking-widest hover:bg-brand-dark transition-all shadow-lg shadow-brand/20 active:scale-[0.99] mt-2">
                <span x-text="role === 'seller' ? 'Open My Store →' : 'Create Account →'">Create Account →</span>
            </button>
        </form>

        {{-- Login link --}}
        <div class="flex items-center gap-4 my-6">
            <div class="h-px flex-1 bg-slate-100"></div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Have an account?</span>
            <div class="h-px flex-1 bg-slate-100"></div>
        </div>

        <a href="{{ route('login') }}"
           class="flex items-center justify-center gap-3 w-full py-4 rounded-xl border-2 border-slate-200 text-slate-700 font-bold text-sm hover:border-brand/40 hover:text-brand transition-all group">
            <i class="fa-solid fa-right-to-bracket text-slate-400 group-hover:text-brand transition-colors"></i>
            Sign in to my account
        </a>

        <p class="text-center text-[11px] text-slate-400 font-medium mt-5 flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-shield-halved text-brand"></i>
            Your data is encrypted and secure on Izifai.
        </p>
    </div>
</x-guest-layout>
