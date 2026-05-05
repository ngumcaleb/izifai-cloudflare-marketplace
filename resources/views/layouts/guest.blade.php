<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') - Izifai</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { 
                font-family: 'Outfit', sans-serif; 
                background-color: #F8FAFC;
                background-image: radial-gradient(#16a34a 0.5px, transparent 0.5px);
                background-size: 40px 40px;
                background-attachment: fixed;
                opacity: 0.98;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="antialiased text-slate-800 min-h-screen flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-[440px] animate-in fade-in zoom-in duration-500">
            <!-- Logo Section -->
            <div class="flex justify-center mb-10">
                <a href="/">
                    <x-application-logo class="h-12 w-auto" />
                </a>
            </div>

            <!-- Main Auth Card -->
            <div class="glass-card rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] p-10 md:p-12 relative overflow-hidden">
                <!-- Subtle Accent -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-green-600/10"></div>
                
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer / Social Proof -->
            <div class="mt-12 text-center">
                <p class="text-slate-400 text-xs font-medium tracking-tight">
                    Trusted by <span class="text-green-600 font-bold">10,000+</span> businesses across Cameroon.
                </p>
                <div class="mt-4 flex justify-center gap-6 opacity-30 grayscale contrast-125">
                    <!-- Placeholder logos or subtle icons -->
                    <div class="w-20 h-4 bg-slate-400 rounded-full"></div>
                    <div class="w-20 h-4 bg-slate-400 rounded-full"></div>
                    <div class="w-20 h-4 bg-slate-400 rounded-full"></div>
                </div>
            </div>
        </div>
    </body>
</html>