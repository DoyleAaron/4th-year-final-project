<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaguesSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('leagues')->insert([
            [
                'name' => 'SmartScore Elite',
                'code' => 'ELITE123',
                'is_private' => true,
                'created_by' => 1, // or another user ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fantasy Rivals',
                'code' => 'RIVALS456',
                'is_private' => false,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

