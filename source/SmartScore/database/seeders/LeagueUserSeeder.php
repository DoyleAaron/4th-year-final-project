<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\League;

class LeagueUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'test@example.com')->first(); // update this line
        $league1 = League::where('code', 'ELITE123')->first();
        $league2 = League::where('code', 'RIVALS456')->first();

        if ($user && $league1 && $league2) {
            DB::table('league_user')->insert([
                [
                    'user_id' => $user->id,
                    'league_id' => $league1->id,
                    'points' => 42,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $user->id,
                    'league_id' => $league2->id,
                    'points' => 58,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        } else {
            $this->command->warn('User or leagues not found – skipping league_user insert.');
        }
    }
}
