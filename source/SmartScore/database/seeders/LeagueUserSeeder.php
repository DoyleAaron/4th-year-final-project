<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeagueUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('league_user')->insert([
            [
                'league_id' => 1,
                'user_id' => 1,
                'points' => 42,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'league_id' => 2,
                'user_id' => 1,
                'points' => 58,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
