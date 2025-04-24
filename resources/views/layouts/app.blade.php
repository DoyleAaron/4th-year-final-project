<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ config('app.name', 'SmartScore') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div id="app">
        {{-- Navbar --}}
        <nav class="bg-white shadow">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    {{-- Left: Logo / App Name --}}
                    <div class="flex-shrink-0">
                        <a href="{{ url('/') }}" class="text-xl font-extrabold text-gray-800">
                            {{ config('app.name', 'SmartScore') }}
                        </a>
                    </div>

                    {{-- Centre: Nav Links --}}
                    <div class="hidden md:flex space-x-8 justify-center flex-1">
                        <a href="{{ url('team/select') }}" class="text-gray-800 hover:text-indigo-600 font-medium">My Team</a>
                        <a href="{{ url('/transfers') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Transfers</a>
                        <a href="{{ url('/leagues') }}" class="text-gray-800 hover:text-indigo-600 font-medium">My Leagues</a>
                        <a href="{{ url('/predict') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Points Predictor</a>
                        <a href="{{ url('/comparison') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Player Comparison</a>
                        <a href="{{ url('/transfer_rec') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Transfer Recommendation</a>
                    </div>

                    {{-- Right: User/Auth --}}
                    <div class="flex items-center space-x-4">
                        @guest
                        @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-gray-800 hover:text-indigo-600">Login</a>
                        @endif
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-800 hover:text-indigo-600">Register</a>
                        @endif
                        @else
                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-800 hover:text-indigo-600 font-medium">
                                Logout
                            </button>
                        </form>
                        @endauth

                        @endguest
                    </div>
                </div>
            </div>
        </nav>
        <main class="py-6 items-center">
            @yield('content')
        </main>

    </div>
</body>

</html>