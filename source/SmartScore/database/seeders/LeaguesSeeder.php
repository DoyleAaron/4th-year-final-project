<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaguesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leagues')->insert([
            [
                'name' => 'SmartScore Elite',
                'code' => 'ELITE123',
                'created_by' => 1,
                'is_private' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fantasy Rivals',
                'code' => 'RIVALS456',
                'created_by' => 1,
                'is_private' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
