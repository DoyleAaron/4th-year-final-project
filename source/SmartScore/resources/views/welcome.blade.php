<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>SmartScore</title>

    {{-- Load Vite assets (CSS + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white scroll-smooth">

    {{-- Your Tailwind UI component --}}
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">SmartScore</span>
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Open main menu</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="#features" class="text-sm font-semibold text-gray-900">Features</a>
                    <a href="#how-it-works" class="text-sm font-semibold text-gray-900">How It Works</a>
                    <a href="#about-us" class="text-sm font-semibold text-gray-900">About us</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="#" class="text-sm font-semibold text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
                </div>
            </nav>
        </header>

        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56" id="features">
                <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                </div>
                <div class="text-center">
                    <h1 class="text-5xl font-bold tracking-tight text-gray-900 sm:text-7xl">Welcome to SmartScore</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">An AI powered fantasy football web application that aims to power your management decisions.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="#" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</a>
                        <a href="#" class="text-sm font-semibold text-gray-900">Log in<span aria-hidden="true">→</span></a>
                    </div>
                    <div class="bg-white py-16 sm:py-20">
                        <div class="mx-auto max-w-7xl px-6 lg:px-8">
                            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center sm:grid-cols-2">

                                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                                    <dt class="text-base text-gray-600">To build your fantasy team</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl min-h-[60px]">500+<br>Players</dd>
                                </div>

                                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                                    <dt class="text-base text-gray-600">Helping you make informed decisions</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl min-h-[60px]">10+<br>AI Models</dd>
                                </div>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <section id="how-it-works" class="py-24 sm:py-32 bg-transparent mb-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8 mb-32">
                    <div class="sm:text-center">
                        <h2 class="text-lg font-semibold text-indigo-600">How It Works</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Smarter decisions. Better results.</p>
                        <p class="mt-6 text-lg leading-8 text-gray-600">SmartScore blends your football instincts with powerful AI to keep you ahead of the game.</p>
                    </div>

                    <div class="mt-20 grid grid-cols-1 gap-y-16 gap-x-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="text-center px-6">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Build Your Team</h3>
                            <p class="mt-2 text-base text-gray-600">Pick from 500+ real Premier League players and form your winning lineup.</p>
                        </div>

                        <div class="text-center px-6">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-4H5v4H2l5 5 5-5H9zM15 7h4V3h3l-5-5-5 5h3v4z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Get AI Insights</h3>
                            <p class="mt-2 text-base text-gray-600">Our models assess data like form, injuries and fixtures to guide your weekly choices.</p>
                        </div>

                        <div class="text-center px-6">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Compete with Friends</h3>
                            <p class="mt-2 text-base text-gray-600">Set up private leagues with your mates and go head-to-head using your own custom rules.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="about-us" class="py-24 sm:py-32 bg-transparent mb-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="sm:text-center">
                        <h2 class="text-lg font-semibold text-indigo-600">About SmartScore</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Started from a fourth year project</p>
                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            SmartScore began as my final year project — but really, it started long before that. I'm someone who's obsessed with football and fantasy football. Each week, I’d dig into player stats, watch match highlights, and try to make smarter transfers than my friends. But there was always something missing...
                        </p>
                        <p class="mt-4 text-lg leading-8 text-gray-600">
                            I realised there wasn’t a single app out there that truly combined the excitement of fantasy football with the predictive power of AI. So I decided to build one. SmartScore is my vision of what fantasy football should be: data-driven, competitive, and tailored to how real fans actually play the game.
                        </p>
                    </div>
                    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                        </div>
                    </div>
                </div>
        </div>

</body>

</html>