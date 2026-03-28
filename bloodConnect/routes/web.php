<?php

use App\Http\Controllers\BloodrequestsController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. Show the Request Form
Route::get('/find-blood', [BloodrequestsController::class, 'create'])->name('blood.request.create');

// 3. Handle Form Submission
Route::post('/find-blood', [BloodrequestsController::class, 'store'])->name('blood.request.store');
// Change this:
// Route::get('/', function () { return view('welcome'); });

// To this:
Route::get('/', [BloodrequestsController::class, 'index'])->name('home');