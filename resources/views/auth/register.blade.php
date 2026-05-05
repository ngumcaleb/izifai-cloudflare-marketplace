<x-guest-layout>
    @section('title', 'Create Account')

    <style>
        .iti {
            width: 100%;
        }

        .iti__flag {
            background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/img/flags.png");
        }

        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {
            .iti__flag {
                background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/img/flags@2x.png");
            }
        }

        .iti__selected-flag {
            background-color: transparent !important;
            border-radius: 1rem 0 0 1rem;
            padding-left: 1.25rem !important;
        }

        .iti--allow-dropdown input {
            padding-left: 3.5rem !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Join Izifai</h2>
        <p class="text-sm text-slate-500 font-medium">Start buying or selling in Cameroon.</p>
    </div>

    <div x-data="{ role: 'buyer' }">
        <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
            @csrf

            <!-- Role Toggle -->
            <div class="flex p-1 bg-slate-50/80 rounded-2xl mb-6">
                <button type="button" @click="role = 'buyer'"
                    :class="role === 'buyer' ? 'bg-white shadow-sm text-green-600' : 'text-slate-400'"
                    class="flex-1 py-3 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all">
                    Buyer
                </button>
                <button type="button" @click="role = 'seller'"
                    :class="role === 'seller' ? 'bg-white shadow-sm text-green-600' : 'text-slate-400'"
                    class="flex-1 py-3 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all">
                    Seller
                </button>
                <input type="hidden" name="role" :value="role">
            </div>

            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Full
                    Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="John Doe"
                    class="w-full px-5 py-3.5 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-semibold transition-all outline-none">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email"
                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    placeholder="name@email.com"
                    class="w-full px-5 py-3.5 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-semibold transition-all outline-none">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- WhatsApp Number -->
            <div class="space-y-1.5">
                <label for="phone" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">WhatsApp
                    (For Business)</label>
                <div class="relative">
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                        class="w-full pr-5 py-3.5 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-bold tracking-wider transition-all outline-none">
                    <input type="hidden" name="full_phone" id="full_phone">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <!-- Store Name -->
            <div class="space-y-1.5" x-show="role === 'seller'" x-transition>
                <label for="store_name"
                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Business Name</label>
                <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}"
                    :required="role === 'seller'" placeholder="My Amazing Store"
                    class="w-full px-5 py-3.5 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-semibold transition-all outline-none">
                <x-input-error :messages="$errors->get('store_name')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="password"
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full px-5 py-3.5 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-semibold transition-all outline-none">
                </div>
                <div class="space-y-1.5">
                    <label for="password_confirmation"
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Confirm</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" placeholder="••••••••"
                        class="w-full px-5 py-3.5 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-semibold transition-all outline-none">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit"
                    class="w-full bg-[#16A34A] text-white py-4 rounded-2xl font-bold text-sm hover:bg-green-700 transition-all shadow-xl shadow-green-600/10 active:scale-[0.98]">
                    Create My Account
                </button>
            </div>
        </form>
    </div>

    <div class="mt-10 pt-8 border-t border-slate-50 text-center">
        <p class="text-xs text-slate-400 font-bold tracking-tight">
            Already have an account?
            <a href="{{ route('login') }}" class="text-green-600 hover:underline ml-1">Sign In</a>
        </p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.querySelector("#phone");
            const fullPhoneInput = document.querySelector("#full_phone");
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "cm",
                separateDialCode: true,
                preferredCountries: ["cm", "ng", "ci", "gh", "sn"],
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            const form = document.querySelector("#registerForm");
            form.addEventListener('submit', function () {
                fullPhoneInput.value = iti.getNumber();
            });
        });
    </script>
</x-guest-layout>