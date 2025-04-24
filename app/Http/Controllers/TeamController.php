<?php

namespace App\Http\Controllers;
// I had to get help from ChatGPT here as when I was trying this originally trying to split the players to appear in seperate lists was an issue and I couldnt get it right.
// I also had to get help with the validation rules for the players such as not allowing duplicates and ensuring there is only 3 players from the same team as well as obtaining and calculating the points total.

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
        $user = Auth::user();
        $selectedPlayers = $user->players()->with('team')->get();

        if ($user->players()->count() === 15) {
            return redirect()->route('team.pick');
        }

        $players = Player::with('team')->get();

        return view('team.select', compact('players', 'selectedPlayers'));
    }



    /**
     * Handle the selected players being submitted.
     */
    public function storeInitial(Request $request)
    {
        $request->validate([
            'players' => ['required', 'array', 'size:15'],
            'players.*' => ['required', 'distinct', 'exists:players,id'],
        ]);

        $userId = auth()->id();

        if (!$userId) {
            dd('Not logged in');
        }

        // Remove any old records for this user
        \DB::table('player_user')->where('user_id', $userId)->delete();

        // Group selected players by position
        $playersData = Player::whereIn('id', $request->players)->get()->groupBy('position');

        // Define how many of each position should be in the starting 11
        $starterCounts = ['GK' => 1, 'DF' => 4, 'MF' => 4, 'FW' => 2];

        // Pick starting players based on count per position
        $starters = [];
        foreach ($starterCounts as $position => $count) {
            if (isset($playersData[$position])) {
                $starters = array_merge(
                    $starters,
                    $playersData[$position]->take($count)->pluck('id')->toArray()
                );
            }
        }

        foreach ($request->players as $playerId) {
            \DB::table('player_user')->insert([
                'user_id' => $userId,
                'player_id' => $playerId,
                'points' => 0,
                'starting' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('team.pick')->with('success', 'Team selected! Starting XI has been set.');
    }


    public function pick()
    {
        $user = Auth::user();

        $squad = $user->players()->with('team')->withPivot('starting')->get();

        $points = [];

        $outfieldPoints = \DB::table('outfield_stats')->select('player_', 'fantasy_points')->get();
        foreach ($outfieldPoints as $row) {
            $points[$row->player_] = $row->fantasy_points;
        }

        $keeperPoints = \DB::table('keeper_stats')->select('player_', 'fantasy_points')->get();
        foreach ($keeperPoints as $row) {
            $points[$row->player_] = $row->fantasy_points;
        }

        foreach ($squad as $player) {
            $player->fantasy_points = $points[$player->name] ?? 0;
        }

        $totalPoints = $squad->filter(function ($player) {
            return $player->pivot->starting;
        })->sum(function ($player) {
            return $player->fantasy_points ?? 0;
        });

        $leagueIds = \DB::table('league_user')
            ->where('user_id', $user->id)
            ->pluck('league_id');

        foreach ($leagueIds as $leagueId) {
            \DB::table('league_user')->where([
                'user_id' => $user->id,
                'league_id' => $leagueId,
            ])->update([
                'points' => $totalPoints,
                'updated_at' => now(),
            ]);
        }

        $startingIds = $squad->filter(fn($p) => $p->pivot->starting)->pluck('id')->toArray();
        $subIds = $squad->filter(fn($p) => !$p->pivot->starting)->pluck('id')->toArray();

        return view('team.pick', compact('squad', 'startingIds', 'subIds', 'totalPoints'));
    }

    public function saveLineup(Request $request)
    {
        $request->validate([
            'starters' => ['required', 'array', 'size:11'],
            'subs' => ['required', 'array', 'size:4'],
            'starters.*' => ['required', 'distinct', 'exists:players,id'],
            'subs.*' => ['required', 'distinct', 'exists:players,id'],
        ]);

        // Check for duplicates between starters and subs
        $overlap = array_intersect($request->starters, $request->subs);

        if (count($overlap) > 0) {
            return back()->withErrors(['subs' => 'A player cannot be both in the starting XI and on the bench.'])->withInput();
        }

        $user = Auth::user();

        // Update pivot table: set 'starting' true/false
        foreach ($request->starters as $playerId) {
            \DB::table('player_user')
                ->where('user_id', $user->id)
                ->where('player_id', $playerId)
                ->update(['starting' => true]);
        }

        foreach ($request->subs as $playerId) {
            \DB::table('player_user')
                ->where('user_id', $user->id)
                ->where('player_id', $playerId)
                ->update(['starting' => false]);
        }

        return redirect()->route('home')->with('success', 'Starting 11 and subs saved!');
    }

    public function transfers()
    {
        $user = Auth::user();
        $selectedPlayers = $user->players()->with('team')->get();
        $allPlayers = Player::with('team')->get();

        return view('team.transfer', compact('selectedPlayers', 'allPlayers'));
    }

    public function storeTransfers(Request $request)
    {
        $request->validate([
            'players' => ['required', 'array', 'size:15'],
            'players.*' => ['required', 'distinct', 'exists:players,id'],
        ]);

        $user = Auth::user();
        $newIds = collect($request->players);
        $currentIds = $user->players->pluck('id');

        $transfersMade = $newIds->diff($currentIds)->count();

        if ($transfersMade > 3) {
            return back()->withErrors(['players' => 'You can only make up to 3 transfers.']);
        }

        $totalCost = Player::whereIn('id', $request->players)->sum('value');
        if ($totalCost > 100) {
            return back()->withErrors(['players' => 'You’ve exceeded your £100m budget.']);
        }

        // Load fantasy points from stats tables
        $outfieldPoints = \DB::table('outfield_stats')->select('player_', 'fantasy_points')->get();
        $keeperPoints = \DB::table('keeper_stats')->select('player_', 'fantasy_points')->get();

        $pointsLookup = [];
        foreach ($outfieldPoints as $row) {
            $pointsLookup[$row->player_] = $row->fantasy_points;
        }
        foreach ($keeperPoints as $row) {
            $pointsLookup[$row->player_] = $row->fantasy_points;
        }

        // Preserve previous starting values
        $previousStarting = \DB::table('player_user')
            ->where('user_id', $user->id)
            ->pluck('starting', 'player_id');

        // Get player names to match stats
        $playerNames = Player::whereIn('id', $request->players)->pluck('name', 'id');

        // Remove old entries
        \DB::table('player_user')->where('user_id', $user->id)->delete();

        foreach ($request->players as $playerId) {
            $name = $playerNames[$playerId];
            $weeklyPoints = $pointsLookup[$name] ?? 0;

            \DB::table('player_user')->insert([
                'user_id' => $user->id,
                'player_id' => $playerId,
                'points' => $weeklyPoints,
                'starting' => $previousStarting[$playerId] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('team.pick')->with('success', 'Transfers complete! Now pick your starting XI.');
    }
}
