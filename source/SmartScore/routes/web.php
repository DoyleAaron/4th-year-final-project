<?php

use Illuminate\Support\Facades\Route;use App\Http\Controllers\PlayerPredictionController;

Route::get('/player/{id}/prediction', 
    [PlayerPredictionController::class, 'show'])
    ->name('player.prediction');

Route::get('/', function () {
    return view('welcome');
});

