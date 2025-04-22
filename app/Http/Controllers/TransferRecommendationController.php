<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TransferRecommendationController extends Controller
{
    public function showForm()
    {
        $players = Player::orderBy('name')->get();
        return view('transfer_rec', compact('players'));
    }

    public function runPrediction(Request $request)
    {
        $player = Player::findOrFail($request->player_id);

        // Debug: Log player and opponent data
        Log::info("Selected Player: " . $player->name);

        // Check if they are GK, DF, MF, FW based on the position
        $isGK = strtoupper(substr($player->position, 0, 2)) === 'GK';
        $isDF = strtoupper(substr($player->position, 0, 2)) === 'DF';
        $isMF = strtoupper(substr($player->position, 0, 2)) === 'MF';
        $isFW = strtoupper(substr($player->position, 0, 2)) === 'FW';

        $predictionRow = DB::table('transfer_rec_inputs')
            ->whereRaw('player = ?', [strtolower($player->name)])
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
                'Saves' => $predictionRow->saves ?? 0,
                'Save%' => $predictionRow->save_pct ?? 0,
                'SoTA' => $predictionRow->sota ?? 0,
                'CS' => $predictionRow->cs ?? 0,
                'CS%' => $predictionRow->cs_pct ?? 0,
            ];
        } elseif ($isDF) {
            $input = [
                'Tkl%' => $predictionRow->tkl_pct ?? 0,
                'Tkl+Int' => $predictionRow->tkl_plus_int ?? 0,
                'Clr' => $predictionRow->clr ?? 0,
                'Blocks' => $predictionRow->blocks ?? 0,
                'Sh' => $predictionRow->sh ?? 0,
            ];
        } elseif ($isMF) {
            $input = [
                'PrgP' => $predictionRow->prgp ?? 0,
                'xAG.1' => $predictionRow->xag_1 ?? 0,
                'xG.1' => $predictionRow->xg_1 ?? 0,
                'PrgC' => $predictionRow->prgc ?? 0,
            ];
        } elseif ($isFW) {
            $input = [
                'xG.1' => $predictionRow->xg_1 ?? 0,
                'Gls.1' => $predictionRow->gls_1 ?? 0,
                'npxG+xAG.1' => $predictionRow->npxg_plus_xag_1 ?? 0,
                'xAG.1' => $predictionRow->xag_1 ?? 0,
            ];
        } else {
            return back()->with('error', 'Invalid player position.');
        }


        // Call the model for prediction
        $modelFilename = $isGK ? 'goalkeeper_transfer.pkl' : ($isDF ? 'defender_transfer.pkl' : ($isMF ? 'midfielder_transfer.pkl' : 'attacker_transfer.pkl'));
        Log::info("Model input data for player {$player->name}:", $input);
        $ModelResult = $this->callPredictionModel($input, $modelFilename);
        Log::info('Raw model result:', ['result' => $ModelResult]);


        $rk = $ModelResult['rk'] ?? null;

        if (is_null($rk)) {
            return back()->with('error', 'No recommendation returned from model.');
        }

        // Determine the correct table based on position
        $table = $isGK ? 'goalkeeper_transfer_rec_inputs' : ($isDF ? 'defender_transfer_rec_inputs' : 'transfer_rec_inputs');

        // Query the DB using rk
        $recommendedPlayer = DB::table($table)->where('rk', $rk)->first();

        if (!$recommendedPlayer) {
            return back()->with('error', 'Recommended player not found in DB.');
        }


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
