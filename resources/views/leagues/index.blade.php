@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <h1 class="text-2xl text-center font-bold text-gray-900 mb-6">Your Leagues</h1>

    {{-- Success & Error Messages --}}
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    {{-- Leagues List --}}
    @forelse ($leagues as $league)
    <div class="mb-4 p-5 bg-white rounded shadow-sm border border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">{{ $league->name }}</h2>
            <p class="text-sm text-gray-500">
                {{ $league->is_private ? 'Private League' : 'Public League' }} &nbsp;|&nbsp;
                Code: <span class="font-mono text-xs">{{ $league->code }}</span>
            </p>
        </div>
        <a href="{{ route('leagues.show', $league->id) }}"
            class="text-sm text-indigo-600 hover:underline font-medium">
            View Leaderboard →
        </a>
    </div>
    @empty
    <p class="text-gray-600 py-6 text-center">You're not in any leagues yet. Use the buttons above to create or join one!</p>
    @endforelse

    {{-- Create/Join Buttons --}}
    <div class="mt-10 flex items-center justify-center gap-x-6">
        <a href="{{ route('leagues.create') }}" class="rounded-md bg-indigo-600 px-6 py-4 text-m font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create a league</a>
        <a href="{{ route('leagues.joinForm') }}" class="text-m font-semibold text-gray-900">Join a league<span aria-hidden="true">→</span></a>
    </div>

    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
</div>

@endsection