@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Pick Your Starting 11</h1>

    {{-- Success or error feedback --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('team.pick.save') }}">
        @csrf

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Starting XI</h2>
            @for ($i = 1; $i <= 11; $i++)
                <div class="mb-2">
                    <select name="starters[]" class="w-full border p-2 rounded">
                        <option value="" disabled selected>Select Player {{ $i }}</option>
                        @foreach($squad as $player)
                            <option value="{{ $player->id }}">
                                {{ $player->name }} ({{ $player->position }}, {{ $player->team->name ?? 'No Team' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endfor
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Substitutes</h2>
            @for ($i = 1; $i <= 4; $i++)
                <div class="mb-2">
                    <select name="subs[]" class="w-full border p-2 rounded">
                        <option value="" disabled selected>Select Sub {{ $i }}</option>
                        @foreach($squad as $player)
                            <option value="{{ $player->id }}">
                                {{ $player->name }} ({{ $player->position }}, {{ $player->team->name ?? 'No Team' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endfor
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Lineup
        </button>
    </form>
</div>
@endsection
