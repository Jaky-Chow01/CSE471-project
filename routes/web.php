<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BloodrequestsController;
use App\Http\Controllers\BloodbanksController;
use App\Http\Controllers\DiagonosticcentersController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\RouteController;

use App\Http\Controllers\DonorController;
use App\Http\Controllers\NidController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NidSubmissionController;

Route::get('/', [BloodrequestsController::class, 'index'])->name('home');

Route::get('/login',    [AuthController::class, 'loginForm'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/logout',   [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register'])->name('register.post');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard',               [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users',                   [AdminController::class, 'users'])->name('admin.users');
    Route::get('/nid',                     [AdminController::class, 'nidQueue'])->name('admin.nid');
    Route::post('/nid/{nid}/verify',       [AdminController::class, 'verifyNid'])->name('admin.nid.verify');
    Route::post('/nid/{nid}/reject',       [AdminController::class, 'rejectNid'])->name('admin.nid.reject');
    Route::get('/track',                          [TrackingController::class, 'adminPanel'])->name('admin.track');
    Route::get('/track/update/{id}/{newStage}',   [TrackingController::class, 'updateStage'])->name('admin.update.stage');
});

Route::prefix('donor')->middleware(['auth', 'role:donor'])->group(function () {
    Route::get('/dashboard', function () {
        $myRequests   = \App\Models\DonationRequest::where('donor_user_id', auth()->id())
                            ->with('bloodRequest')->latest()->get();
        $openRequests = \App\Models\DonationRequest::where('stage', 0)
                            ->whereNull('donor_user_id')
                            ->with('bloodRequest')->latest()->get();
        $nid          = \App\Models\NidVerification::where('user_id', auth()->id())->first();
        return view('donor.dashboard', compact('myRequests', 'openRequests', 'nid'));
    })->name('donor.dashboard');
    Route::post('/request/{id}/accept', [DonorController::class, 'acceptRequest'])->name('donor.request.accept');
    Route::get('/nid',  [NidSubmissionController::class, 'show'])->name('donor.nid');
    Route::post('/nid', [NidSubmissionController::class, 'store'])->name('donor.nid.store');
});

Route::prefix('requester')->middleware(['auth', 'role:requester'])->group(function () {
    Route::get('/dashboard', function () {
        $requests = \App\Models\DonationRequest::where('user_id', auth()->id())->latest()->get();
        $nid      = \App\Models\NidVerification::where('user_id', auth()->id())->first();
        return view('requester.dashboard', compact('requests', 'nid'));
    })->name('requester.dashboard');
    Route::get('/nid',  [NidSubmissionController::class, 'show'])->name('requester.nid');
    Route::post('/nid', [NidSubmissionController::class, 'store'])->name('requester.nid.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/donors',          [DashboardController::class, 'getDonors']);
    Route::get('/api/dashboard/donor/{id}',      [DashboardController::class, 'getDonor']);
    Route::get('/api/dashboard/care/{donorId}',  [DashboardController::class, 'getCare']);
    Route::post('/api/dashboard/care',           [DashboardController::class, 'saveCare']);
    Route::post('/api/dashboard/donor/register', [DashboardController::class, 'registerDonor']);
    Route::get('/api/dashboard/requests',        [DashboardController::class, 'getRequests']);
    Route::get('/api/dashboard/confirmations',   [DashboardController::class, 'getConfirmations']);
    Route::get('/api/dashboard/stats',           [DashboardController::class, 'getStats']);
    Route::post('/api/dashboard/donor/toggle',   [DashboardController::class, 'toggleAvailability']);
    Route::post('/api/dashboard/requests/add',   [DashboardController::class, 'addRequest']);
    Route::post('/api/dashboard/requests/status',[DashboardController::class, 'updateRequestStatus']);
    Route::post('/api/dashboard/confirmations/update', [DashboardController::class, 'updateConfirmation']);
    Route::get('/api/dashboard/analytics',       [DashboardController::class, 'getAnalytics']);
});

Route::get('/track/donor/{token}',     [TrackingController::class, 'donorView'])->name('track.donor');
Route::get('/track/requester/{token}', [TrackingController::class, 'requesterView'])->name('track.requester');

Route::get('/track', function () {
    return redirect()->route('admin.track');
})->middleware(['auth', 'role:admin'])->name('track');

Route::get('/update_stage/{newStage}', function () {
    return redirect()->route('admin.track');
})->middleware(['auth', 'role:admin'])->name('update.stage');

Route::get('/find-blood',  [BloodrequestsController::class, 'create'])->name('blood.request.create');
Route::post('/find-blood', [BloodrequestsController::class, 'store'])->name('blood.request.store');
Route::get('/blood-request-submitted/{token}', [BloodrequestsController::class, 'submitted'])->name('blood.request.submitted');
Route::get('/api/blood-requests',         [BloodrequestsController::class, 'gettingbloodrequest']);
Route::post('/api/blood-requests/edit',   [BloodrequestsController::class, 'editingbloodrequest']);
Route::post('/api/blood-requests/delete', [BloodrequestsController::class, 'deletingbloodrequest']);

Route::get('/blood-banks', [BloodbanksController::class, 'index'])->name('blood.banks');
Route::post('/api/blood-banks/add',    [BloodbanksController::class, 'addingbloodbank']);
Route::post('/api/blood-banks/edit',   [BloodbanksController::class, 'editingbloodbank']);
Route::post('/api/blood-banks/delete', [BloodbanksController::class, 'deletingbloodbank']);
Route::get('/api/blood-banks',         [BloodbanksController::class, 'gettingbloodbank']);

Route::get('/diagnostic-centers', [DiagonosticcentersController::class, 'index'])->name('diagnostic.centers');
Route::post('/api/diagnostic-centers/add',    [DiagonosticcentersController::class, 'addingnew']);
Route::post('/api/diagnostic-centers/edit',   [DiagonosticcentersController::class, 'editingnew']);
Route::post('/api/diagnostic-centers/delete', [DiagonosticcentersController::class, 'deleting']);
Route::get('/api/diagnostic-centers',         [DiagonosticcentersController::class, 'getting']);

Route::get('/blood-types', function () { return view('blood-types'); })->name('blood.types');

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

Route::post('/api/calculate-route', [RouteController::class, 'calculateRoute'])->name('route.calculate');

Route::get('/find-donors',   [DonorController::class, 'home'])->name('find.donors');
Route::get('/search_donors', [DonorController::class, 'search'])->name('search.donors');
