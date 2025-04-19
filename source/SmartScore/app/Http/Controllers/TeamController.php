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

        $userId = auth()->id();

        if (!$userId) {
            dd('Not logged in');
        }

        // Just to be sure: remove old entries before inserting fresh ones
        \DB::table('player_user')->where('user_id', $userId)->delete();

        foreach ($request->players as $playerId) {
            \DB::table('player_user')->insert([
                'user_id' => $userId,
                'player_id' => $playerId,
                'points' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('home')->with('success', '✅ Team saved to DB!');
    }
}
