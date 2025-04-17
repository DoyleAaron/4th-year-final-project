<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LeagueController;

Route::get('/predict', [PredictionController::class, 'showForm'])->name('predict.form');
Route::post('/predict', [PredictionController::class, 'runPrediction'])->name('predict.run');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ChatGPT helped me with structuring the routes and controllers for the league system.
Route::middleware(['auth'])->group(function () {
    Route::get('/leagues', [LeagueController::class, 'index'])->name('leagues.index');
    Route::get('/leagues/create', [LeagueController::class, 'create'])->name('leagues.create');
    Route::post('/leagues', [LeagueController::class, 'store'])->name('leagues.store');
    Route::get('/leagues/{league}', [LeagueController::class, 'show'])->name('leagues.show');


    Route::get('/leagues/join', [LeagueController::class, 'joinForm'])->name('leagues.joinForm');
    Route::post('/leagues/join', [LeagueController::class, 'join'])->name('leagues.join');
});