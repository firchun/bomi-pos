<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title & Description -->
    <title>@yield('title') — Bomi POS</title>
    <meta name="description" content="Login atau daftar ke Bomi POS untuk mengelola bisnis Anda dengan mudah dan efisien.">
    <meta name="keywords" content="Bomi POS, login POS, daftar POS, manajemen bisnis, aplikasi kasir, kasir pintar">
    <meta name="author" content="Bomi Dev">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="@yield('title') — Bomi POS" />
    <meta property="og:description" content="Akses Bomi POS untuk kelola bisnis dan penjualan Anda secara efisien." />
    <meta property="og:image" content="{{ asset('home/images/logo_kasir.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') — Bomi POS">
    <meta name="twitter:description" content="Login atau daftar ke Bomi POS untuk mengelola bisnis Anda dengan mudah dan efisien.">
    <meta name="twitter:image" content="{{ asset('home/images/logo_kasir.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#7e22ce',
                    }
                }
            }
        }
    </script>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    @stack('style')
</head>

<body class="min-h-screen flex items-center justify-center text-zinc-800 dark:text-white bg-cover bg-center scroll-smooth transition-colors duration-500 bg-[url('{{ asset('home2/assets/svg/background.svg') }}')] dark:bg-[url('{{ asset('home2/assets/svg/background-dark.svg') }}')]">
    <main class="w-full max-w-7xl px-4 py-8">
        <!-- Toggle Dark Mode -->
        <div class="flex justify-center mb-4">
            <button @click="darkMode = !darkMode" class="flex items-center gap-2 p-2 rounded-2xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                <i :class="darkMode ? 'fas fa-sun text-white' : 'fas fa-moon text-gray-700 dark:text-white'"></i>
                <span :class="darkMode ? 'text-white' : 'text-gray-700'">
                   Mode
                </span>
            </button>
        </div>

        <!-- Container -->
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <!-- Header -->
                @include('components.auth-header')

                <!-- Main Content -->
                @yield('main')

                <!-- Footer -->
                @include('components.auth-footer')
            </div>
        </div>
    </main>

    @stack('scripts')
</body>

</html>