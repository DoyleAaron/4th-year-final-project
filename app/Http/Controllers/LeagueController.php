<?php
// ChatGPT helped me with structuring the routes and controllers for the league system.
namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeagueController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Make sure the leagues relationship exists and is correct
        $leagues = $user?->leagues ?? collect(); // Safe fallback

        return view('leagues.index', compact('leagues'));
    }

    public function create()
    {
        return view('leagues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_private' => 'boolean',
        ]);

        $league = League::create([
            'name' => $request->name,
            'code' => strtoupper(Str::random(6)),
            'created_by' => auth()->id(),
            'is_private' => $request->has('is_private'),
        ]);

        $league->users()->attach(auth()->id(), ['points' => 0]);

        return redirect()->route('leagues.index')->with('success', 'League created!');
    }

    public function joinForm()
    {
        return view('leagues.join');
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:leagues,code',
        ]);

        $league = League::where('code', $request->code)->first();

        if ($league->users->contains(auth()->id())) {
            return redirect()->route('leagues.index')->with('error', 'You are already in this league.');
        }

        $league->users()->attach(auth()->id(), ['points' => 0]);

        return redirect()->route('leagues.index')->with('success', 'You joined the league successfully!');
    }

    public function show(League $league)
    {
        $users = $league->users()->orderByDesc('pivot_points')->get();
        return view('leagues.show', compact('league', 'users'));
    }
}
