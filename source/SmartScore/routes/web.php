<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;
use Illuminate\Support\Facades\Auth;

Route::get('/predict', [PredictionController::class, 'showForm'])->name('predict.form');
Route::post('/predict', [PredictionController::class, 'runPrediction'])->name('predict.run');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
