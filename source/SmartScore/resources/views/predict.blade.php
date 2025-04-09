<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SmartScore - Player Prediction</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-center">SmartScore Prediction</h1>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('predict.run') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Player Dropdown --}}
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

            {{-- Opponent Dropdown --}}
            <div>
                <label for="opponent_id" class="block font-semibold">Select Opponent:</label>
                <select name="opponent_id" id="opponent_id" required class="w-full p-2 border rounded">
                    <option value="" disabled selected>-- Choose opponent team --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Submit Button --}}
            <div class="text-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Predict Points
                </button>
            </div>
        </form>

        {{-- Result --}}
        @isset($predictedPoints)
            <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded text-center">
                <p class="text-lg font-semibold">
                    Predicted Points for {{ $selectedPlayer->name }}: <span class="text-xl">{{ $predictedPoints }}</span>
                </p>
            </div>
        @endisset
    </div>
</body>
</html>
