<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#006d38">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'iziFaii')</title>
    <meta name="description" content="@yield('description', 'Izifai — Buy and Sell in Cameroon. Create your store in 2 minutes.')">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'iziFaii')">
    <meta property="og:description" content="@yield('description', 'Izifai — Buy and Sell in Cameroon. Create your store in 2 minutes.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Izifai">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title', 'iziFaii')">
    <meta name="twitter:description" content="@yield('description', 'Izifai — Buy and Sell in Cameroon. Create your store in 2 minutes.')">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#006d38",
                        "primary-container": "#00a859",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#003317",
                        "primary-fixed-dim": "#59df89",
                        surface: "#f4fcf1",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eef6eb",
                        "surface-container": "#e8f0e6",
                        "on-surface": "#161d17",
                        "on-surface-variant": "#3d4a3f",
                        "outline-variant": "#bccabc",
                        error: "#ba1a1a",
                        "error-container": "#ffdad6",
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"],
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="antialiased min-h-screen flex flex-col lg:flex-row bg-surface-container-lowest">

    @yield('content')

    {{ $slot ?? '' }}

</body>
</html>
