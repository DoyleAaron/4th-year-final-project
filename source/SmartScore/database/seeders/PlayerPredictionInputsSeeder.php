<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PlayerPredictionInputsSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/player_prediction_inputs.csv');
        $data = array_map('str_getcsv', file($path));
        $header = array_map('trim', array_shift($data));

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            DB::table('player_prediction_inputs')->insert([
                'date' => $rowData['Date'] ?? null,
                'venue' => $rowData['Venue'] ?? null,
                'result' => $rowData['Result'] ?? null,
                'team' => $rowData['Team'] ?? null,
                'opponent' => $rowData['Opponent'] ?? null,
                'started' => ($rowData['Started'] ?? 'N') === 'Y',
                'position' => $rowData['Position'] ?? null,
                'minutes_played' => is_numeric($rowData['Minutes-Played']) ? (float) $rowData['Minutes-Played'] : null,
                'goals' => is_numeric($rowData['Goals']) ? (float) $rowData['Goals'] : null,
                'assists' => is_numeric($rowData['Assists']) ? (float) $rowData['Assists'] : null,
                'player_name' => $rowData['Player-Name'] ?? null,
                'clean_sheet' => is_numeric($rowData['Clean-Sheet']) ? (int) $rowData['Clean-Sheet'] : null,
                'fantasy_points' => is_numeric($rowData['Fantasy-Points']) ? (float) $rowData['Fantasy-Points'] : null,
                'team_id' => is_numeric($rowData['TeamID']) ? (int) $rowData['TeamID'] : null,
                'player_code' => is_numeric($rowData['Player-Code']) ? (int) $rowData['Player-Code'] : null,
                'opponent_id' => is_numeric($rowData['OpponentID']) ? (int) $rowData['OpponentID'] : null,
                'venue_id' => is_numeric($rowData['VenueID']) ? (int) $rowData['VenueID'] : null,
                'started_id' => 1,
                'player_goals_form' => is_numeric($rowData['Player_Goals_Form']) ? (float) $rowData['Player_Goals_Form'] : null,
                'player_assists_form' => is_numeric($rowData['Player_Assists_Form']) ? (float) $rowData['Player_Assists_Form'] : null,
                'player_minutes_form' => is_numeric($rowData['Player_Minutes_Form']) ? (float) $rowData['Player_Minutes_Form'] : null,
                'player_ycard_form' => is_numeric($rowData['Player_Ycard_Form']) ? (float) $rowData['Player_Ycard_Form'] : null,
                'player_rcard_form' => is_numeric($rowData['Player_Rcard_Form']) ? (float) $rowData['Player_Rcard_Form'] : null,
                'player_clean_sheet_form' => is_numeric($rowData['Player_Clean_Sheet_Form']) ? (float) $rowData['Player_Clean_Sheet_Form'] : null,
                'player_fp_form' => is_numeric($rowData['Player_FP_Form']) ? (float) $rowData['Player_FP_Form'] : null,
                'team_form_rating' => is_numeric($rowData['Team_Form_Rating']) ? (float) $rowData['Team_Form_Rating'] : null,
                'opponent_form_rating' => is_numeric($rowData['Opponent_Form_Rating']) ? (float) $rowData['Opponent_Form_Rating'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
