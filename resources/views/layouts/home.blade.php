<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Free CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
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
