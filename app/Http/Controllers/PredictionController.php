<?php

namespace App\Http\Controllers;

// ChatGPT helped me with this code as I needed to figure out how to structure some parts of the code and how to make it work with the external hosting.
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;



class PredictionController extends Controller
{
    public function showForm()
    {
        $players = Player::orderBy('name')->get();
        $teams = DB::table('teams')->get();
        return view('predict', compact('players', 'teams'));
    }

    public function runPrediction(Request $request)
    {
        $player = Player::findOrFail($request->player_id);
        $opponent = DB::table('teams')->find($request->opponent_id);

        // Debug: Log player and opponent data
        Log::info("Selected Player: " . $player->name);
        Log::info("Opponent: " . $opponent->name);

        // Check if they are GK, DF, MF, FW based on the position
        $isGK = strtoupper(substr($player->position, 0, 2)) === 'GK';
        $isDF = strtoupper(substr($player->position, 0, 2)) === 'DF';
        $isMF = strtoupper(substr($player->position, 0, 2)) === 'MF';
        $isFW = strtoupper(substr($player->position, 0, 2)) === 'FW';

        // Fetch the relevant prediction input data
        $playerNameHyphenated = str_replace(' ', '-', $player->name);

        $predictionRow = DB::table('player_prediction_inputs')
            ->whereRaw('LOWER(player_name) = ?', [strtolower($playerNameHyphenated)])
            ->where('opponent', $opponent->name)
            ->orderByDesc('date')
            ->first();



        // Debug: Log the prediction data
        Log::info("Prediction data for player " . $player->name . ": " . json_encode($predictionRow));

        if (!$predictionRow) {
            return back()->with('error', 'No prediction input data found for this player.');
        }

        // Build the input structure based on position
        // Build the input structure based on position
        if ($isGK) {
            $input = [
                'TeamID' => $predictionRow->team_id ?? 0,
                'OpponentID' => $predictionRow->opponent_id ?? 0,
                'Player-Code' => $predictionRow->player_code ?? 0,
                'Team_Form_Rating' => $predictionRow->team_form_rating ?? 0,
                'Opponent_Form_Rating' => $predictionRow->opponent_form_rating ?? 0,
                'StartedID' => $predictionRow->started_id ?? 0,
                'Player_Saves_Form' => $predictionRow->player_saves_form ?? 0,
                'Player_Clean_Sheet_Form' => $predictionRow->player_clean_sheet_form ?? 0,
                'Player_Goals_Against_Form' => $predictionRow->player_goals_against_form ?? 0,
                'Player_FP_Form' => $predictionRow->player_fp_form ?? 0,
            ];
        } elseif ($isDF) {
            $input = [
                'VenueID' => $predictionRow->venue_id ?? 0,
                'TeamID' => $predictionRow->team_id ?? 0,
                'OpponentID' => $predictionRow->opponent_id ?? 0,
                'Player-Code' => $predictionRow->player_code ?? 0,
                'Team_Form_Rating' => $predictionRow->team_form_rating ?? 0,
                'Opponent_Form_Rating' => $predictionRow->opponent_form_rating ?? 0,
                'StartedID' => $predictionRow->started_id ?? 0,
                'Player_Goals_Form' => $predictionRow->player_goals_form ?? 0,
                'Player_Assists_Form' => $predictionRow->player_assists_form ?? 0,
                'Player_Clean_Sheet_Form' => $predictionRow->player_clean_sheet_form ?? 0,
                'Player_Ycard_Form' => $predictionRow->player_ycard_form ?? 0,
                'Player_Rcard_Form' => $predictionRow->player_rcard_form ?? 0,
                'Player_FP_Form' => $predictionRow->player_fp_form ?? 0,
            ];
        } elseif ($isMF) {
            $input = [
                'VenueID' => $predictionRow->venue_id ?? 0,
                'TeamID' => $predictionRow->team_id ?? 0,
                'OpponentID' => $predictionRow->opponent_id ?? 0,
                'Player-Code' => $predictionRow->player_code ?? 0,
                'Team_Form_Rating' => $predictionRow->team_form_rating ?? 0,
                'Opponent_Form_Rating' => $predictionRow->opponent_form_rating ?? 0,
                'StartedID' => $predictionRow->started_id ?? 0,
                'Player_Goals_Form' => $predictionRow->player_goals_form ?? 0,
                'Player_Assists_Form' => $predictionRow->player_assists_form ?? 0,
                'Player_Clean_Sheet_Form' => $predictionRow->player_clean_sheet_form ?? 0,
                'Player_Ycard_Form' => $predictionRow->player_ycard_form ?? 0,
                'Player_Rcard_Form' => $predictionRow->player_rcard_form ?? 0,
                'Player_FP_Form' => $predictionRow->player_fp_form ?? 0,
            ];
        } elseif ($isFW) {
            $input = [
                'VenueID' => $predictionRow->venue_id ?? 0,
                'TeamID' => $predictionRow->team_id ?? 0,
                'OpponentID' => $predictionRow->opponent_id ?? 0,
                'Player-Code' => $predictionRow->player_code ?? 0,
                'Team_Form_Rating' => $predictionRow->team_form_rating ?? 0,
                'Opponent_Form_Rating' => $predictionRow->opponent_form_rating ?? 0,
                'StartedID' => $predictionRow->started_id ?? 0,
                'Player_Goals_Form' => $predictionRow->player_goals_form ?? 0,
                'Player_Assists_Form' => $predictionRow->player_assists_form ?? 0,
                'Player_Ycard_Form' => $predictionRow->player_ycard_form ?? 0,
                'Player_Rcard_Form' => $predictionRow->player_rcard_form ?? 0,
                'Player_FP_Form' => $predictionRow->player_fp_form ?? 0,
            ];
        } else {
            return back()->with('error', 'Invalid player position.');
        }


        // Call the model for prediction
        $modelFilename = $isGK ? 'GK_RF_model.pkl' : ($isDF ? 'DEF_RF_model.pkl' : ($isMF ? 'MID_RF_model.pkl' : 'ATT_RF_model.pkl'));
        Log::info("Model input data for player {$player->name}:", $input);
        $predictedPoints = $this->callPredictionModel($input, $modelFilename);

        return view('predict', [
            'players' => Player::orderBy('name')->get(),
            'selectedPlayer' => $player,
            'predictedPoints' => round((float) $predictedPoints, 1),
            'teams' => DB::table('teams')->get(),
        ]);
    }

    private function callPredictionModel($input, $modelFilename)
    {
        try {
            $response = \Http::timeout(10)->post('https://SmartScore-ML.onrender.com/predict/points', [
                'input' => $input,
                'model' => $modelFilename,
            ]);

            if ($response->successful()) {
                return $response->json('prediction');
            }

            \Log::error('Prediction API failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return '0'; // fallback if API fails
        } catch (\Exception $e) {
            \Log::error('Exception calling prediction API: ' . $e->getMessage());
            return '0';
        }
    }
}
