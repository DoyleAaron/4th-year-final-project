<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncPlayerCodes extends Command
{
    protected $signature = 'sync:player-codes';

    protected $description = 'Sync player codes from prediction inputs to the players table';

    public function handle()
    {
        $this->info('Syncing player codes...');

        $inputs = DB::table('player_prediction_inputs')->get();

        foreach ($inputs as $input) {
            $normalisedInputName = strtolower(str_replace('-', ' ', $input->player_name));

            $player = DB::table('players')
                ->whereRaw("LOWER(REPLACE(name, '-', ' ')) = ?", [$normalisedInputName])
                ->first();

            if ($player) {
                DB::table('players')
                    ->where('id', $player->id)
                    ->update(['player_code' => $input->player_code]);

                $this->info("Updated {$player->name} with code {$input->player_code}");
            } else {
                $this->warn("No match found for input: {$input->player_name}");
            }
        }

        $this->info('Sync complete.');
    }
}
