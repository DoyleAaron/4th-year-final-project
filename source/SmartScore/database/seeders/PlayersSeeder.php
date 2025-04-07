<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('players')->insert([
            [
                'name' => 'Erling Haaland',
                'position' => 'Forward',
                'team' => 'Manchester City',
                'shirt_number' => 9,
                'photo' => 'players/haaland.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bukayo Saka',
                'position' => 'Midfielder',
                'team' => 'Arsenal',
                'shirt_number' => 7,
                'photo' => 'players/saka.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mohamed Salah',
                'position' => 'Forward',
                'team' => 'Liverpool',
                'shirt_number' => 11,
                'photo' => 'players/salah.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
