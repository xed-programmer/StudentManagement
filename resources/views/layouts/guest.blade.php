<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>