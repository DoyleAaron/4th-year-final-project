@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SmartScore - Player Prediction</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>

<body class="h-screen overflow-hidden bg-gray-100 relative">
    <div class="absolute inset-0 z-0 overflow-hidden blur-3xl pointer-events-none">
        <div class="absolute inset-0 w-full h-full bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>

    <!-- Centred Content Container -->
    <div class="h-full flex items-center justify-center z-10 relative">
        <div class="max-w-xl w-full bg-white p-10 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold mb-6 text-center">Transfer Recommendation</h1>

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('predict.run') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Player Dropdown -->
                <div>
                    <label for="player_id" class="block font-semibold">Select Player:</label>
                    <select name="player_id" id="player_id" required class="w-full p-2 border rounded">
                        <option value="" disabled selected>-- Choose a player --</option>
                        @foreach($players as $player)
                        <option value="{{ $player->id }}"
                            @if(isset($selectedPlayer) && $selectedPlayer->id === $player->id) selected @endif>
                            {{ $player->name }} ({{ $player->position }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Give me a recommendation
                    </button>
                </div>
            </form>

            <!-- Prediction Result -->
            @isset($recommendedPlayer)
            <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded text-center">
                <p class="text-lg font-semibold">
                    Recommended replacement for {{ $selectedPlayer->name }}:
                    <span class="text-xl">{{ $recommendedPlayer }}</span>
                </p>
            </div>
            @endisset
        </div>
    </div>

</body>

</html>
@endsection
