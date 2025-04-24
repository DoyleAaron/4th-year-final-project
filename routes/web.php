<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TransferRecommendationController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ComparisonController;

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
    Route::get('/leagues/joinForm', [LeagueController::class, 'joinForm'])->name('leagues.joinForm');
    Route::post('/leagues/join', [LeagueController::class, 'join'])->name('leagues.join');
    

    Route::get('/leagues/{league}', [LeagueController::class, 'show'])->name('leagues.show');
});

Route::get('/team/select', [TeamController::class, 'select'])->name('team.select');
Route::post('/team/select', [TeamController::class, 'storeInitial'])->name('team.store.initial');

Route::get('/team/pick', [TeamController::class, 'pick'])->name('team.pick');
Route::post('/team/pick', [TeamController::class, 'saveLineup'])->name('team.pick.save');

Route::get('/predict', [PredictionController::class, 'showForm'])->name('predict.form');
Route::post('/predict', [PredictionController::class, 'runPrediction'])->name('predict.run');

Route::get('/transfer_rec', [TransferRecommendationController::class, 'showForm'])->name('transfer_rec.form');
Route::post('/transfer_rec', [TransferRecommendationController::class, 'runPrediction'])->name('transfer_rec.run');

Route::get('/comparison', [ComparisonController::class, 'showForm'])->name('comparison.form');
Route::post('/comparison', [ComparisonController::class, 'runPrediction'])->name('comparison.run');

Route::get('/transfers', [TeamController::class, 'transfers'])->name('team.transfers');
Route::post('/transfers/store', [TeamController::class, 'storeTransfers'])->name('team.transfers.store');
