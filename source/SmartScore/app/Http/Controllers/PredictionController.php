<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PredictionController extends Controller
{
    public function showForm()
    {
        $players = Player::orderBy('name')->get();
        return view('predict', compact('players'));
    }

    public function runPrediction(Request $request)
    {
        $player = Player::findOrFail($request->player_id);

        // Check if they are GK
        $isGK = strtoupper($player->position) === 'GK';

        // Fetch most recent prediction input row for this player (match on name or code)
        $predictionRow = DB::table('player_prediction_inputs')
            ->where('player_name', $player->name)
            ->latest()
            ->first();

        if (!$predictionRow) {
            return back()->with('error', 'No prediction input data found for this player.');
        }

        // Load model
        if ($isGK) {
            $model = include base_path('app/ML/GK_RF.php'); // or however you saved it
        } else {
            $model = include base_path('app/ML/Outfield_RF.php');
        }

        // Convert to input array
        $input = [
            'TeamID' => $predictionRow->team_id,
            'OpponentID' => $predictionRow->opponent_id,
            'Player-Code' => $predictionRow->player_code,
            'Team_Form_Rating' => $predictionRow->team_form_rating,
            'Opponent_Form_Rating' => $predictionRow->opponent_form_rating,
            'StartedID' => $predictionRow->started_id,
            'Player_Saves_Form' => $predictionRow->player_saves_form ?? 0,
            'Player_Clean_Sheet_Form' => $predictionRow->player_clean_sheet_form ?? 0,
            'Player_Goals_Against_Form' => $predictionRow->player_goals_against_form ?? 0,
            'Player_FP_Form' => $predictionRow->player_fp_form ?? 0,
        ];

        $predictedPoints = $model->predict([$input])[0];

        return view('predict', [
            'players' => Player::orderBy('name')->get(),
            'selectedPlayer' => $player,
            'predictedPoints' => $predictedPoints
        ]);
    }
}
