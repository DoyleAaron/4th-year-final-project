<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerPredictionController extends Controller
{
    public function show($id)
    {
        $player = Player::with(['team', 'nextOpponent'])->findOrFail($id);

        // Temporary logic for prediction if no model/table
        $predictedPoints = rand(3, 12); // Later replace with real logic

        return view('player.prediction', [
            'player' => $player,
            'predictedPoints' => $predictedPoints,
        ]);
    }
}
