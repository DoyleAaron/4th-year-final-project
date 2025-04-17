@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-purple-800 mb-6 text-center">Join a League</h2>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leagues.join') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="code" class="block text-purple-700 font-medium mb-1">League Code</label>
            <input type="text" name="code" id="code" required
                   class="w-full border border-purple-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="Enter league code">
        </div>

        <button type="submit"
                class="w-full !bg-purple-700 hover:bg-purple-800 text-white font-medium py-2 px-4 rounded">
            Join League
        </button>
    </form>
</div>
@endsection
