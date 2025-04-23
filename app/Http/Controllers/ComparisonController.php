<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
{
    public function showForm()
    {
        $players = Player::orderBy('name')->get();
        return view('comparison', compact('players'));
    }

    public function runPrediction(Request $request)
    {
        $player1 = Player::findOrFail($request->player_id);
        $player2 = Player::findOrFail($request->player_id2);

        // Debug: Log players data
        Log::info("Selected Player 1: " . $player1->name);
        Log::info("Selected Player 2: " . $player2->name);

        // Check if they are GK, DF, MF, FW based on the position
        $isGK = strtoupper(substr($player1->position, 0, 2)) === 'GK';
        $isDF = strtoupper(substr($player1->position, 0, 2)) === 'DF';
        $isMF = strtoupper(substr($player1->position, 0, 2)) === 'MF';
        $isFW = strtoupper(substr($player1->position, 0, 2)) === 'FW';

        $isGK2 = strtoupper(substr($player2->position, 0, 2)) === 'GK';
        $isDF2 = strtoupper(substr($player2->position, 0, 2)) === 'DF';
        $isMF2 = strtoupper(substr($player2->position, 0, 2)) === 'MF';
        $isFW2 = strtoupper(substr($player2->position, 0, 2)) === 'FW';

        $predictionRow1 = DB::table('transfer_rec_inputs')
            ->whereRaw('player = ?', [strtolower($player1->name)])
            ->first();

        // Debug: Log the prediction data
        Log::info("Prediction data for player " . $player1->name . ": " . json_encode($predictionRow1));

        $predictionRow2 = DB::table('transfer_rec_inputs')
            ->whereRaw('player = ?', [strtolower($player2->name)])
            ->first();
        // Debug: Log the prediction data
        Log::info("Prediction data for player " . $player2->name . ": " . json_encode($predictionRow2));

        if (!$predictionRow1 || !$predictionRow2) {
            return back()->with('error', 'No prediction input data found for this player.');
        }


        // Call the model for prediction
        $modelFilename = 'FW_MF_comparison_model.pkl';
        Log::info("Model input data for player {$player1->name}:", $input);
        $ModelResult = $this->callPredictionModel($input, $modelFilename);
        Log::info('Raw model result:', ['result' => $ModelResult]);
        $recommendedPlayer = $ModelResult['player'] ?? 'Unknown';


        return view('transfer_rec', [
            'players' => Player::orderBy('name')->get(),
            'selectedPlayer' => $player,
            'recommendedPlayer' => $recommendedPlayer,
        ]);
    }

    private function callPredictionModel($input, $modelFilename)
    {
        try {
            $response = \Http::timeout(10)->post('https://SmartScore-ML.onrender.com/predict/transfer', [
                'input' => $input,
                'model' => $modelFilename,
            ]);

            if ($response->successful()) {
                return $response->json();
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
