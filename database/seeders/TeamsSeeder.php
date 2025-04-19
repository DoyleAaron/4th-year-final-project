<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    public function run()
    {
        DB::table('teams')->insert([
            ['id' => 0, 'name' => 'Arsenal', 'api_name' => 'Arsenal FC'],
            ['id' => 1, 'name' => 'Aston Villa', 'api_name' => 'Aston Villa FC'],
            ['id' => 2, 'name' => 'Bournemouth', 'api_name' => 'AFC Bournemouth'],
            ['id' => 3, 'name' => 'Brentford', 'api_name' => 'Brentford FC'],
            ['id' => 4, 'name' => 'Brighton', 'api_name' => 'Brighton & Hove Albion FC'],
            ['id' => 5, 'name' => 'Chelsea', 'api_name' => 'Chelsea FC'],
            ['id' => 6, 'name' => 'Crystal Palace', 'api_name' => 'Crystal Palace FC'],
            ['id' => 7, 'name' => 'Everton', 'api_name' => 'Everton FC'],
            ['id' => 8, 'name' => 'Fulham', 'api_name' => 'Fulham FC'],
            ['id' => 9, 'name' => 'Ipswich Town', 'api_name' => 'Ipswich Town FC'],
            ['id' => 10, 'name' => 'Leicester', 'api_name' => 'Leicester City FC'],
            ['id' => 11, 'name' => 'Liverpool', 'api_name' => 'Liverpool FC'],
            ['id' => 12, 'name' => 'Man City', 'api_name' => 'Manchester City FC'],
            ['id' => 13, 'name' => 'Man United', 'api_name' => 'Manchester United FC'],
            ['id' => 14, 'name' => 'Newcastle', 'api_name' => 'Newcastle United FC'],
            ['id' => 15, 'name' => 'Nott\'ham Forest', 'api_name' => 'Nottingham Forest FC'],
            ['id' => 16, 'name' => 'Southampton', 'api_name' => 'Southampton FC'],
            ['id' => 17, 'name' => 'Tottenham', 'api_name' => 'Tottenham Hotspur FC'],
            ['id' => 18, 'name' => 'West Ham', 'api_name' => 'West Ham United FC'],
            ['id' => 19, 'name' => 'Wolves', 'api_name' => 'Wolverhampton Wanderers FC'],
        ]);
    }
}

