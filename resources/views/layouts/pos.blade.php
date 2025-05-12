<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Bomi POS</title>

    <!-- General CSS Files -->
    <link href="{{ asset('pos/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spinkit/css/spinkit.min.css">

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('pos/css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <div id="app">
        <div class="wrapper">
            <!-- Sidebar -->
            @include('components.pos-header')
            
            <!-- Header -->
            <div id="main-content" class="container">
                @include('components.pos-sidebar')
                
            </div>
            
            {{ $slot }}
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('pos/js/script.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('pos/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
    @livewireScripts
</body>
</html>
