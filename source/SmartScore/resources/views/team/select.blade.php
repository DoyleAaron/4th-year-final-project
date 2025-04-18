@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Select Your Team</h1>

    <div class="mb-4 text-gray-700">
        <strong>Budget Remaining:</strong> £<span id="budgetDisplay">100.0</span> / 100
    </div>

    <form method="POST" action="{{ route('team.store') }}">
        @csrf

        @php
        $positions = [
            'GK' => ['label' => 'Goalkeeper', 'count' => 2],
            'DF' => ['label' => 'Defender', 'count' => 5],
            'MF' => ['label' => 'Midfielder', 'count' => 5],
            'FW' => ['label' => 'Forward', 'count' => 3],
        ];
        @endphp

        @foreach($positions as $code => $info)
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">{{ $info['label'] }}s</h2>
                @for ($i = 1; $i <= $info['count']; $i++)
                    <div class="mb-2">
                        <select name="players[]" class="player-select w-full border p-2 rounded" onchange="updateBudget(this)">
                            <option value="" disabled selected>Select a {{ $info['label'] }}</option>
                            @foreach($players->where('position', $code) as $player)
                                <option value="{{ $player->id }}" data-price="{{ $player->value }}">
                                    {{ $player->name }} ({{ $player->team->name ?? 'No Team' }}) – £{{ number_format($player->value, 1) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endfor
            </div>
        @endforeach

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Team
            </button>
        </div>
    </form>
</div>

<script>
    function updateBudget() {
        let total = 0;
        document.querySelectorAll('.player-select').forEach(select => {
            const selected = select.options[select.selectedIndex];
            const price = selected.dataset.price;
            if (price) total += parseFloat(price);
        });
        document.getElementById('budgetDisplay').textContent = (100 - total).toFixed(1);
    }
</script>
@endsection
