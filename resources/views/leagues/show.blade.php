@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md text-center">
    <h2 class="text-3xl font-extrabold text-purple-800 mb-2">
        {{ $league->is_private ? 'Private' : 'Public' }} Leaderboard
    </h2>

    <p class="text-sm text-gray-500 mb-6">
        League Code: <span class="font-mono text-purple-700">{{ $league->code }}</span>
    </p>

    @if ($users->count())
    <div class="w-full flex justify-center">
        <table class="w-[500px] text-center divide-y divide-gray-200">
            <thead class="bg-purple-50 text-purple-700 text-lg">
                <tr>
                    <th class="px-4 py-3 font-semibold">Position</th>
                    <th class="px-4 py-3 font-semibold">Player</th>
                    <th class="px-4 py-3 font-semibold">Points</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100 text-xl">
                @foreach ($users as $index => $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 font-bold text-purple-900">#{{ $index + 1 }}</td>
                    <td class="px-4 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                    <td class="px-4 py-4 font-bold text-purple-700">{{ $user->pivot->points }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-center text-gray-500">No users in this league yet.</p>
    @endif
</div>
@endsection
