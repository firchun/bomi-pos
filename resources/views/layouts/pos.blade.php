<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Bomi POS</title>

    <!-- General CSS Files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spinkit/css/spinkit.min.css">

    @stack('style')

    <!-- Template CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "resto-purple": "#6D28D9",
                        "resto-purple-light": "#8B5CF6",
                        "resto-purple-lighter": "#A78BFA",
                        "resto-purple-dark": "#5B21B6",
                        "resto-bg": "#F3F4F6",
                        "resto-text-primary": "#1F2937",
                        "resto-text-secondary": "#6B7280",
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="{{ asset('pos/css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex h-screen overflow-hidden bg-resto-bg">
    <div>
        @include('components.pos-sidebar')
        {{ $slot }}
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('pos/js/script.js') }}"></script>
    @stack('scripts')
    @livewireScripts
</body>

</html>
