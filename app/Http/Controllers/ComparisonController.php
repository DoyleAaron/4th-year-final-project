<?php

namespace App\Http\Controllers;

// ChatGPT gave me some ideas on how to abstract this as there was originally a lot of repetitive code.

use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
{
    private function preparePlayerInput($player, $row)
    {
        $isGK = strtoupper(substr($player->position, 0, 2)) === 'GK';
        $isDF = strtoupper(substr($player->position, 0, 2)) === 'DF';
        $isMF = strtoupper(substr($player->position, 0, 2)) === 'MF';
        $isFW = strtoupper(substr($player->position, 0, 2)) === 'FW';

        if ($isGK) {
            $input = [
                'Save%' => $row->save_pct ?? 0,
                'CS%' => $row->cs_pct ?? 0,
                'CS' => $row->cs ?? 0,
                'SoTA' => $row->sota ?? 0,
            ];
        } elseif ($isDF) {
            $input = [
                'Tkl%' => $row->tkl_pct ?? 0,
                'Tkl+Int' => $row->tkl_plus_int ?? 0,
                'Clr' => $row->clr ?? 0,
                'Blocks' => $row->blocks ?? 0,
                'Sh' => $row->sh ?? 0,
            ];
        } elseif ($isMF) {
            $input = [
                'PrgP' => $row->prgp ?? 0,
                'xAG.1' => $row->xag_1 ?? 0,
                'xG.1' => $row->xg_1 ?? 0,
                'PrgC' => $row->prgc ?? 0,
            ];
        } elseif ($isFW) {
            $input = [
                'xG.1' => $row->xg_1 ?? 0,
                'Gls.1' => $row->gls_1 ?? 0,
                'npxG+xAG.1' => $row->npxg_plus_xag_1 ?? 0,
                'xAG.1' => $row->xag_1 ?? 0,
                'Gls' => $predictionRow->gls ?? 0,
                'Ast' => $predictionRow->ast ?? 0,
                'npxG.1' => $predictionRow->npxg_1 ?? 0,

            ];
        } else {
            return null;
        }

        return $input;
    }

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

        $position1 = strtoupper(substr($player1->position, 0, 2));
        $position2 = strtoupper(substr($player2->position, 0, 2));

        if ($position1 !== $position2) {
            return back()->with('error', 'Please compare players in the same position.');
        }

        // Use a helper to prepare input for each player
        $input1 = $this->preparePlayerInput($player1, $predictionRow1);
        $input2 = $this->preparePlayerInput($player2, $predictionRow2);


        // Call the model for prediction
        switch ($position1) {
            case 'GK':
                $modelFilename = 'GK_comparison_model.pkl';
                break;
            case 'DF':
                $modelFilename = 'DF_comparison_model.pkl';
                break;
            case 'MF':
                $modelFilename = 'MF_FW_comparison_model.pkl';
                break;
            case 'FW':
                $modelFilename = 'MF_FW_comparison_model.pkl';
                break;
            default:
                return back()->with('error', 'Invalid position detected.');
        }

        $ModelResult = $this->callPredictionModel([$input1, $input2], $modelFilename);
        Log::info('Raw model result:', ['result' => $ModelResult]);
        $recommendedIndex = $ModelResult['recommended_index'] ?? null;
        $recommendedPlayer = $recommendedIndex === 0 ? $player1->name : ($recommendedIndex === 1 ? $player2->name : 'Unknown');



        return view('comparison', [
            'players' => Player::orderBy('name')->get(),
            'selectedPlayer1' => $player1,
            'selectedPlayer2' => $player2,
            'recommendedPlayer' => $recommendedPlayer,
        ]);
    }

    private function callPredictionModel($inputs, $modelFilename)
    {
        try {
            $response = Http::timeout(10)->post('https://SmartScore-ML.onrender.com/predict/comparison', [
                'input' => $inputs,
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
