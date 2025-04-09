<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player Points Prediction</title>
</head>
<body>
    <h1>Fantasy Points Prediction</h1>

    <form action="{{ route('predict.run') }}" method="POST">
        @csrf
        <label for="player">Select a player:</label>
        <select name="player_id" id="player">
            @foreach ($players as $player)
                <option value="{{ $player->id }}" {{ (old('player_id') == $player->id || (isset($selectedPlayer) && $selectedPlayer->id == $player->id)) ? 'selected' : '' }}>
                    {{ $player->name }} ({{ $player->position }})
                </option>
            @endforeach
        </select>
        <button type="submit">Predict</button>
    </form>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if(isset($predictedPoints))
        <h2>Predicted Points for {{ $selectedPlayer->name }}: <strong>{{ number_format($predictedPoints, 2) }}</strong></h2>
    @endif
</body>
</html>
