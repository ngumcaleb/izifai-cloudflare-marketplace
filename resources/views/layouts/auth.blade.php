<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#659316">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title', 'iziFaii')</title>
    <meta name="description" content="@yield('description', 'Izifai — Buy and Sell in Cameroon. Create your store in 2 minutes.')">
    <meta property="og:title" content="Izifai — Buy and Sell in Cameroon">
    <meta property="og:description" content="Izifai — Buy and Sell in Cameroon. Create your store in 2 minutes.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Izifai">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#659316",
                        "primary-container": "#9acd32",
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
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="antialiased min-h-screen flex flex-col lg:flex-row bg-surface-container-lowest">

    @yield('content')

    {{ $slot ?? '' }}

</body>
</html>
