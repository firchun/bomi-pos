<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="title" content="@yield('meta-title','Bomi POS - Solusi Aplikasi Pengelola Restaurant & Retail')">
    <meta name="description" content="@yield('meta-description','Bomi POS menyediakan fitur lengkap bagi pemilik restaurant dan retail untuk mengelola usaha mereka dengan mudah. Daftar restaurant, produk, dan retail tersedia di platform ini. Coba sekarang!')">
    <meta name="keywords" content="@yield('meta-keywords','Bomi, Bomi POS, Aplikasi Restaurant, Aplikasi Retail, Restaurant Merauke, Retail Merauke, Daftar Restaurant, Solusi POS, Software POS, Manajemen Usaha')">
    <meta name="author" content="BomiDev">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="@yield('meta-og-title', 'Bomi POS - Solusi Aplikasi Pengelola Restaurant & Retail')">
    <meta property="og:description" content="@yield('meta-og-description', 'Bomi POS menyediakan fitur lengkap bagi pemilik restaurant dan retail untuk mengelola usaha mereka dengan mudah. Daftar restaurant, produk, dan retail tersedia di platform ini. Coba sekarang!')">
    <meta property="og:image" content="@yield('meta-og-image', asset('home/images/logo_kasir.png'))">
    <meta property="og:url" content="@yield('meta-og-url', url()->current())">
    <meta property="og:type" content="@yield('meta-og-type', 'website')">    

    <title>@yield('title', 'Home') — Bomi POS</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    
    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Free CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    @stack('css')
</head>

<body>

    @include('components.home-header')
    @yield('content')
    @include('components.home-footer')

    <!-- # JS Plugins -->
    <script src="{{ asset('home/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('home/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('home/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('home/plugins/scrollmenu/scrollmenu.min.js') }}"></script>

    @stack('js')

    <!-- Main Script -->
    <script src="js/script.js"></script>
</body>

</html>
