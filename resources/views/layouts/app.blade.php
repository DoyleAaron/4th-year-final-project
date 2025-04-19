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
                        <a href="{{ url('/points') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Points</a>
                        <a href="{{ url('/transfers') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Transfers</a>
                        <a href="{{ url('/leagues') }}" class="text-gray-800 hover:text-indigo-600 font-medium">My Leagues</a>
                        <a href="{{ url('/fixture-analyser') }}" class="text-gray-800 hover:text-indigo-600 font-medium">Fixture Analyser</a>
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
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-800 hover:text-indigo-600 focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg hidden group-hover:block z-50">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
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