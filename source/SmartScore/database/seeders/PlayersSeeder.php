<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayersSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/players.csv');
        $data = array_map('str_getcsv', file($path));
        $header = array_map('trim', array_shift($data));

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            DB::table('players')->insert([
                'name' => $rowData['Player'] ?? null,
                'nation' => $rowData['Nation'] ?? null,
                'position' => $rowData['Pos'] ?? null,
                'squad' => $rowData['Squad'] ?? null,
                'age' => $rowData['Age'] ?? null,
                'born' => is_numeric($rowData['Born']) ? (int) $rowData['Born'] : null,
                'matches_played' => is_numeric($rowData['MP']) ? (int) $rowData['MP'] : null,
                'starts' => is_numeric($rowData['Starts']) ? (int) $rowData['Starts'] : null,
                'minutes' => is_numeric($rowData['Min']) ? (int) $rowData['Min'] : null,
                'goals' => is_numeric($rowData['Gls']) ? (float) $rowData['Gls'] : null,
                'assists' => is_numeric($rowData['Ast']) ? (float) $rowData['Ast'] : null,
                'xg' => is_numeric($rowData['xG']) ? (float) $rowData['xG'] : null,
                'npxg' => is_numeric($rowData['npxG']) ? (float) $rowData['npxG'] : null,
                'xag' => is_numeric($rowData['xAG']) ? (float) $rowData['xAG'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
