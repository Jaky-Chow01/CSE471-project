<?php

use App\Http\Controllers\BloodbanksController;
use App\Http\Controllers\BloodrequestsController;
use App\Http\Controllers\DiagonosticcentersController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;


// 1. Home page shows the latest blood requests
Route::get('/', [BloodrequestsController::class, 'index'])->name('home');

// 2. Show the Request Form
Route::get('/find-blood', [BloodrequestsController::class, 'create'])->name('blood.request.create');

// 3. Handle Form Submission
Route::post('/find-blood', [BloodrequestsController::class, 'store'])->name('blood.request.store');

// 4. Blood Banks Page
Route::get('/blood-banks', [BloodbanksController::class, 'index'])->name('blood.banks');

// 5. Diagnostic Centers Page
Route::get('/diagnostic-centers', [DiagonosticcentersController::class, 'index'])->name('diagnostic.centers');

Route::get('/blood-types', function () {
    return view('blood-types');
})->name('blood.types');

// Leaderboard
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');