@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-purple-800 mb-6 text-center">Create a League</h2>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leagues.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-purple-700 font-medium mb-1">League Name</label>
            <input type="text" name="name" id="name" required
                class="w-full border border-purple-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_private" id="is_private" value="1"
                class="text-purple-600 focus:ring-purple-500 rounded border-gray-300">
            <label for="is_private" class="ml-2 text-sm text-gray-700">Make this league private</label>
        </div>

        <button type="submit"
            class="w-full !bg-purple-700 !hover:bg-purple-800 text-white font-medium py-2 px-4 rounded">
            Create League
        </button>
    </form>
</div>
@endsection
