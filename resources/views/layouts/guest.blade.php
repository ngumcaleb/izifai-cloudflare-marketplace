<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Izifai') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind config MUST be defined before the CDN loads -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: '#16a34a',
                        'brand-dark': '#14532d',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Outfit', sans-serif; }
        .input-field {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            font-weight: 500;
            outline: none;
            transition: all 0.2s;
            background: #f8fafc;
            color: #0f172a;
        }
        .input-field:focus {
            border-color: #16a34a;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(22,163,74,0.08);
        }
        .input-field::placeholder { color: #94a3b8; font-weight: 400; }
        .auth-panel-bg {
            background: linear-gradient(145deg, #0f2716 0%, #16a34a 60%, #22c55e 100%);
        }
        .floating-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeUp { animation: fadeUp 0.5s ease both; }
    </style>
</head>
<body class="antialiased min-h-screen flex">

    {{-- LEFT: BRAND PANEL (hidden on mobile) --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[38%] auth-panel-bg flex-col justify-between p-12 relative overflow-hidden shrink-0">

        {{-- Background decorations --}}
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-[-80px] left-[-80px] w-96 h-96 rounded-full bg-white"></div>
            <div class="absolute bottom-[-60px] right-[-60px] w-72 h-72 rounded-full bg-white"></div>
        </div>

        {{-- Logo --}}
        <a href="/" class="relative z-10">
            <x-application-logo class="h-10 w-auto brightness-0 invert" />
        </a>

        {{-- Headline --}}
        <div class="relative z-10 space-y-6">
            <div class="inline-flex items-center gap-2 bg-white/15 border border-white/20 text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest backdrop-blur-sm">
                <i class="fa-solid fa-certificate text-[8px]"></i>
                Cameroon's #1 Marketplace
            </div>
            <h1 class="text-4xl xl:text-5xl font-black text-white leading-[1.1] tracking-tight">
                Trade smarter.<br>
                <span class="text-green-200">Grow faster.</span>
            </h1>
            <p class="text-green-100 font-medium text-sm leading-relaxed max-w-sm">
                Join thousands of verified sellers and buyers building the future of commerce in Cameroon.
            </p>

            {{-- Trust stats --}}
            <div class="grid grid-cols-3 gap-4 pt-4">
                <div class="floating-card p-4 text-center">
                    <p class="text-2xl font-black text-white">5k+</p>
                    <p class="text-[10px] text-green-200 font-bold uppercase tracking-wider mt-1">Sellers</p>
                </div>
                <div class="floating-card p-4 text-center">
                    <p class="text-2xl font-black text-white">20k+</p>
                    <p class="text-[10px] text-green-200 font-bold uppercase tracking-wider mt-1">Products</p>
                </div>
                <div class="floating-card p-4 text-center">
                    <p class="text-2xl font-black text-white">10+</p>
                    <p class="text-[10px] text-green-200 font-bold uppercase tracking-wider mt-1">Cities</p>
                </div>
            </div>
        </div>

        {{-- Footer note --}}
        <p class="text-green-200/60 text-[11px] font-medium relative z-10">
            &copy; {{ date('Y') }} Izifai &mdash; Secure &amp; Trusted
        </p>
    </div>

    {{-- RIGHT: FORM PANEL --}}
    <div class="flex-1 flex flex-col min-h-screen bg-slate-50">

        {{-- Mobile Logo --}}
        <div class="lg:hidden p-6 border-b border-slate-100 bg-white">
            <a href="/">
                <x-application-logo class="h-7 w-auto" />
            </a>
        </div>

        {{-- Form Content --}}
        <div class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-[440px] animate-fadeUp">
                {{ $slot }}
            </div>
        </div>

        {{-- Bottom note --}}
        <div class="py-6 text-center lg:hidden">
            <p class="text-[11px] text-slate-400 font-medium">&copy; {{ date('Y') }} Izifai &mdash; Premium Local Commerce</p>
        </div>
    </div>

</body>
</html>
