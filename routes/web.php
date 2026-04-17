<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\NidController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\AuthController;

// Home — donor map search
Route::get('/', [DonorController::class, 'home'])->name('home');

// Donor search API
Route::get('/search_donors', [DonorController::class, 'search'])->name('search.donors');

// Admin NID portal
Route::get('/admin', [NidController::class, 'adminPortal'])->name('admin');
Route::post('/upload_nid', [NidController::class, 'upload'])->name('upload.nid');
Route::post('/verify_nid', [NidController::class, 'verify'])->name('verify.nid');

// Auth
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Tracking
Route::get('/track', [TrackingController::class, 'adminView'])->name('track');
Route::get('/track/donor/{token}', [TrackingController::class, 'donorView'])->name('track.donor');
Route::get('/track/requester/{token}', [TrackingController::class, 'requesterView'])->name('track.requester');
Route::get('/update_stage/{newStage}', [TrackingController::class, 'updateStage'])->name('update.stage');

