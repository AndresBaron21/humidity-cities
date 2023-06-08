<?php

use Illuminate\Support\Facades\Route;

// Controller routes
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoricalLogController;

// Routes

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/historical-log', [HistoricalLogController::class, 'index'])->name('historical-log');

// Route::get('/', function () {
//     return view('welcome');
// });


