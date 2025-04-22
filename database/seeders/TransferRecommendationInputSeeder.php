<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransferRecommendationInputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/24_25_prem_player_stats_clean.csv');

        if (!\File::exists($path)) {
            $this->command->error("CSV file not found at: {$path}");
            return;
        }

        $data = array_map('str_getcsv', file($path));
        $header = array_map('trim', $data[0]);
        unset($data[0]); // Remove header row

        foreach ($data as $row) {
            $row = array_combine($header, $row);
            
            if ($row['player'] === 'Player') {
                continue;
            }

            \DB::table('transfer_rec_inputs')->insert([
                'rk' => $row['Rk'] ?? null,
                'player' => $row['Player'] ?? null,
                'nation' => $row['Nation'] ?? null,
                'pos' => $row['Pos'] ?? null,
                'squad' => $row['Squad'] ?? null,
                'born' => $row['Born'] ?? null,
                'mp' => $row['MP'] ?? null,
                'starts' => $row['Starts'] ?? null,
                'min' => $row['Min'] ?? null,
                'nineties' => $row['90s'] ?? null,
                'gls' => $row['Gls'] ?? null,
                'ast' => $row['Ast'] ?? null,
                'g_plus_a' => $row['G+A'] ?? null,
                'g_minus_pk' => $row['G-PK'] ?? null,
                'pk' => $row['PK'] ?? null,
                'pkatt' => $row['PKatt'] ?? null,
                'crdy' => $row['CrdY'] ?? null,
                'crdr' => $row['CrdR'] ?? null,
                'xg' => $row['xG'] ?? null,
                'npxg' => $row['npxG'] ?? null,
                'xag' => $row['xAG'] ?? null,
                'npxg_plus_xag' => $row['npxG+xAG'] ?? null,
                'prgc' => $row['PrgC'] ?? null,
                'prgp' => $row['PrgP'] ?? null,
                'prgr' => $row['PrgR'] ?? null,
                'gls_1' => $row['Gls.1'] ?? null,
                'ast_1' => $row['Ast.1'] ?? null,
                'g_plus_a_1' => $row['G+A.1'] ?? null,
                'g_minus_pk_1' => $row['G-PK.1'] ?? null,
                'g_plus_a_minus_pk' => $row['G+A-PK'] ?? null,
                'xg_1' => $row['xG.1'] ?? null,
                'xag_1' => $row['xAG.1'] ?? null,
                'xg_plus_xag' => $row['xG+xAG'] ?? null,
                'npxg_1' => $row['npxG.1'] ?? null,
                'npxg_plus_xag_1' => $row['npxG+xAG.1'] ?? null,
                'matches' => $row['Matches'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("transfer_rec_inputs seeded successfully.");
    }
}
