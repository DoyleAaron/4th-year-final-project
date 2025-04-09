<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GoalkeeperPredictionsInputSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/goalkeeper_predictions_input.csv');
        $data = array_map('str_getcsv', file($path));
        $header = array_map('trim', array_shift($data));

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            DB::table('goalkeeper_predictions_input')->insert([
                'result' => $rowData['Result'] ?? null,
                'team' => $rowData['Team'] ?? null,
                'opponent' => $rowData['Opponent'] ?? null,
                'started' => ($rowData['Started'] ?? 'N') === 'Y' ? 1 : 0,
                'position' => $rowData['Position'] ?? null,
                'minutes_played' => is_numeric($rowData['Minutes-Played']) ? (float) $rowData['Minutes-Played'] : null,
                'sota' => is_numeric($rowData['SoTA']) ? (float) $rowData['SoTA'] : null,
                'ga' => is_numeric($rowData['GA']) ? (float) $rowData['GA'] : null,
                'saves' => is_numeric($rowData['Saves']) ? (float) $rowData['Saves'] : null,
                'save_percentage' => is_numeric($rowData['Save%']) ? (float) $rowData['Save%'] : null,
                'cs' => is_numeric($rowData['CS']) ? (float) $rowData['CS'] : null,
                'player_name' => $rowData['Player-Name'] ?? null,
                'fantasy_points' => is_numeric($rowData['fantasy-points']) ? (float) $rowData['fantasy-points'] : null,
                'player_saves_form' => is_numeric($rowData['Player_Saves_Form']) ? (float) $rowData['Player_Saves_Form'] : null,
                'player_clean_sheet_form' => is_numeric($rowData['Player_Clean_Sheet_Form']) ? (float) $rowData['Player_Clean_Sheet_Form'] : null,
                'player_goals_against_form' => is_numeric($rowData['Player_Goals_Against_Form']) ? (float) $rowData['Player_Goals_Against_Form'] : null,
                'player_fp_form' => is_numeric($rowData['Player_FP_Form']) ? (float) $rowData['Player_FP_Form'] : null,
                'team_id' => is_numeric($rowData['TeamID']) ? (int) $rowData['TeamID'] : null,
                'player_code' => is_numeric($rowData['Player-Code']) ? (int) $rowData['Player-Code'] : null,
                'opponent_id' => is_numeric($rowData['OpponentID']) ? (int) $rowData['OpponentID'] : null,
                'started_id' => is_numeric($rowData['StartedID']) ? (int) $rowData['StartedID'] : null,
                'team_form_rating' => is_numeric($rowData['Team_Form_Rating']) ? (float) $rowData['Team_Form_Rating'] : null,
                'opponent_form_rating' => is_numeric($rowData['Opponent_Form_Rating']) ? (float) $rowData['Opponent_Form_Rating'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
