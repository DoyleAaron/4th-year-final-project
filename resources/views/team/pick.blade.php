@extends('layouts.app')

@section('content')
<div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
    </div>
</div>
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold text-purple-800 mb-6">Pick Your Starting 11</h1>

    <div class="bg-purple-100 text-purple-800 font-semibold p-4 rounded mb-6 text-lg shadow-sm">
        Total Fantasy Points: {{ $totalPoints }}
    </div>

    {{-- Success message --}}
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded mb-6 shadow">
        {{ session('success') }}
    </div>
    @endif

    {{-- Error messages --}}
    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow">
        <h3 class="font-semibold text-lg mb-2">Error:</h3>
        <ul class="list-disc pl-5 space-y-1 text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('team.pick.save') }}">
        @csrf

        @php
        $groupings = [
        'GK' => ['label' => 'Goalkeeper', 'count' => 1],
        'DF' => ['label' => 'Defender', 'count' => 4],
        'MF' => ['label' => 'Midfielder', 'count' => 4],
        'FW' => ['label' => 'Forward', 'count' => 2],
        ];

        $starterIndex = 0;
        @endphp

        @foreach($groupings as $code => $info)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-purple-700 mb-4 border-b border-purple-200 pb-1">{{ $info['label'] }}s</h2>
            <div class="space-y-3">
                @for ($i = 1; $i <= $info['count']; $i++)
                    @php
                    $starterId=$squad->where('position', $code)
                    ->filter(fn($p) => in_array($p->id, $startingIds))
                    ->values()
                    ->get($i - 1)?->id ?? null;

                    @endphp
                    <div class="bg-purple-50 border border-purple-200 rounded-lg px-4 py-2 flex items-center shadow-sm hover:shadow-md transition-all">
                        <span class="font-medium text-gray-700 w-32">Pick {{ $info['label'] }} {{ $i }}</span>
                        <select name="starters[]" class="ml-4 flex-1 border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 player-select">
                            <option value="" disabled selected>Select a {{ $info['label'] }}</option>

                            @foreach($squad->where('position', $code) as $player)
                            <option value="{{ $player->id }}" {{ $starterId === $player->id ? 'selected' : '' }}>
                                {{ $player->name }} ({{ $player->team->name ?? 'No Team' }}) - {{ $player->fantasy_points }} pts
                            </option>

                            @endforeach
                        </select>

                    </div>
                    @endfor
            </div>
        </div>
        @endforeach

        {{-- Subs --}}
        <div class="mb-10">
            <h2 class="text-xl font-semibold text-purple-700 mb-4 border-b border-purple-200 pb-1">Substitutes (Any Position)</h2>
            <div class="space-y-3">
                @for ($i = 0; $i < 4; $i++)
                    @php $subId=$subIds[$i] ?? null; @endphp
                    <div class="bg-purple-50 border border-purple-200 rounded-lg px-4 py-2 flex items-center shadow-sm hover:shadow-md transition-all">
                    <span class="font-medium text-gray-700 w-32">Sub {{ $i + 1 }}</span>
                    <select name="subs[]" class="ml-4 flex-1 border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 player-select">
                        <option value="" disabled selected>Select Sub {{ $i + 1 }}</option>
                        @foreach($squad as $player)
                        <option value="{{ $player->id }}" {{ $subId === $player->id ? 'selected' : '' }}>
                            {{ $player->name }} ({{ $player->team->name ?? 'No Team' }}) - {{ $player->fantasy_points }} pts
                        </option>
                        @endforeach
                    </select>

            </div>
            @endfor
        </div>
</div>

<div class="flex justify-end">
    <button type="submit" class="!bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg shadow">
        Save Lineup
    </button>
</div>
</form>
</div>
<div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
    <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
    </div>
</div>
@endsection

<!-- This JS was generated by ChatGPT to help me handle multiple duplicate player selections -->
<script>
    function updateSelectOptions() {
        const selects = document.querySelectorAll('.player-select');
        const selectedValues = new Set();

        // Get all selected values across dropdowns
        selects.forEach(select => {
            if (select.value) {
                selectedValues.add(select.value);
            }
        });

        // Reset and filter all options
        selects.forEach(select => {
            const currentValue = select.value;

            Array.from(select.options).forEach(option => {
                if (option.value === "" || option.value === currentValue) {
                    option.disabled = false;
                } else {
                    option.disabled = selectedValues.has(option.value);
                }
            });
        });
    }

    window.addEventListener('load', () => {
        updateSelectOptions();

        document.querySelectorAll('.player-select').forEach(select => {
            select.addEventListener('change', () => {
                updateSelectOptions();
            });
        });
    });
</script>