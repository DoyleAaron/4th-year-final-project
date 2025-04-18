<?php

namespace App\Http\Controllers;
// I had to get help from ChatGPT here as when I was trying this originally trying to split the players to appear in seperate lists was an issue and I couldnt get it right.

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
        return view('team.select', [
            'goalkeepers' => Player::where('position', 'Goalkeeper')->with('team')->get(),
            'defenders' => Player::where('position', 'Defender')->with('team')->get(),
            'midfielders' => Player::where('position', 'Midfielder')->with('team')->get(),
            'forwards' => Player::where('position', 'Forward')->with('team')->get(),
        ]);
    }

    /**
     * Handle the selected players being submitted.
     */
    public function store(Request $request)
    {
        $request->validate([
            'players' => 'required|array|size:11', // assuming 11-player squad
            'players.*' => 'exists:players,id',
        ]);

        $user = Auth::user();

        // Sync selected players into user_players pivot table
        $user->players()->sync(array_fill_keys($request->players, ['points' => 0]));

        return redirect()->route('home')->with('success', 'Team selected successfully!');
    }
}
