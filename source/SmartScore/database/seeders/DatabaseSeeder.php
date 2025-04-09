<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create one test user
        User::firstOrCreate(
            ['email' => 'test@example.com'], // unique constraint check
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Call custom seeders
        $this->call([
            PlayersSeeder::class,
            LeaguesSeeder::class,
            LeagueUserSeeder::class,
            PlayerPredictionInputsSeeder::class,
            GoalkeeperPredictionsInputSeeder::class,
            TeamsSeeder::class,
        ]);
    }
}
