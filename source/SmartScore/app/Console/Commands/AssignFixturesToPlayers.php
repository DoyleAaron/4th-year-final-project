<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssignFixturesToPlayers extends Command
{
    protected $signature = 'assign:fixtures-to-players';
    protected $description = 'Assign upcoming fixtures to each player in the prediction input table.';

    public function handle()
    {
        $this->info("Assigning fixtures to players...");

        $players = DB::table('players')->get();
        $now = Carbon::now();

        foreach ($players as $player) {
            // Get the team using the player's squad field
            $team = DB::table('teams')->where('name', $player->squad)->first();

            if (!$team) {
                $this->warn("Team not found for player {$player->name} with squad {$player->squad}");
                continue;
            }

            // Get the next upcoming fixture for the player's team
            $fixture = DB::table('fixtures')
                ->where(function ($query) use ($team) {
                    $query->where('home_team_id', $team->id)
                        ->orWhere('away_team_id', $team->id);
                })
                ->where('completed', false)
                ->where('kickoff', '>', $now)
                ->orderBy('kickoff')
                ->first();

            if (!$fixture) {
                $this->warn("No upcoming fixture found for team {$team->name}");
                continue;
            }

            // Update the prediction input for this player's code
            // Update the prediction input for this player's code
            DB::table('player_prediction_inputs')
                ->where('player_code', $player->id)
                ->update(['fixture_id' => $fixture->id]);


            $this->info("Assigned fixture ID {$fixture->id} to player {$player->name}");
        }

        $this->info("Finished assigning fixtures to players.");
    }
}
