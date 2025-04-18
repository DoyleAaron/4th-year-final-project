<?php

namespace App\Http\Controllers;
// I had to get help from ChatGPT here as when I was trying this originally trying to split the players to appear in seperate lists was an issue and I couldnt get it right.
// I also had to get help with the validation rules for the players such as not allowing duplicates and ensuring there is only 3 players from the same team.

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Show the team selection form.
     */
    public function select()
    {
        $players = Player::with('team')->get();

        return view('team.select', compact('players'));
    }


    /**
     * Handle the selected players being submitted.
     */
    public function store(Request $request)
{
    $request->validate([
        'players' => ['required', 'array', 'size:15'],
        'players.*' => ['required', 'distinct', 'exists:players,id'],
    ]);

    // Group by team and check max 3
    $players = Player::whereIn('id', $request->players)->get();
    $teamCounts = $players->groupBy('team_id')->map->count();

    if ($teamCounts->max() > 3) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['players' => 'You can only select a maximum of 3 players from the same team.']);
    }

    // Save to pivot
    $user = Auth::user();
    $user->players()->sync(array_fill_keys($request->players, ['points' => 0]));

    return redirect()->route('home')->with('success', 'Team selected successfully!');
}

}
