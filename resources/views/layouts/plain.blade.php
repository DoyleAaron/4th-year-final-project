<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'SmartScore') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- or use mix if you’re not on Vite --}}
</head>
<body class="antialiased text-gray-900 bg-white">
    @yield('content')
</body>
</html>
