<?php

use App\Http\Controllers\BloodbanksController;
use App\Http\Controllers\BloodrequestsController;
use App\Http\Controllers\BloodtypeController;
use App\Http\Controllers\DiagonosticcentersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('add-bloodgroup', [BloodtypeController::class,'adding']); 



Route::PUT('edit-bloodinfo', [BloodtypeController::class,'edit']);


Route::DELETE('delete-bloodinfo', [BloodtypeController::class,'delete']);

Route::GET('show-bloodinfo', [BloodtypeController::class,'show']);

Route::post('add-diagonosticcenter', [DiagonosticcentersController::class,'addingnew']); 


Route::put('edit-diagonosticcenter', [DiagonosticcentersController::class,'editingnew']); 


Route::delete('delete-diagonosticcenter', [DiagonosticcentersController::class,'deleting']);

Route::get('get-diagonosticcenter', [DiagonosticcentersController::class,'getting']);

Route::post('add-bloodbank', [BloodbanksController::class,'addingbloodbank']);


Route::get('get-bloodbank', [BloodbanksController::class,'gettingbloodbank' ]);


Route::put('edit-bloodbanks', [BloodbanksController::class,'editingbloodbank'   ]);


Route::delete('delete-bloodbank', [BloodbanksController::class,'deletingbloodbank'      ]);

Route::post('add-bloodrequest', [BloodrequestsController::class,"addingbloodrequest"    ]);

Route::get('get-bloodrequest', [BloodrequestsController::class,"gettingbloodrequest"    ]);

Route::put('edit-bloodrequest', [BloodrequestsController::class,"editingbloodrequest"       ]);

Route::delete('delete-bloodrequest', [BloodrequestsController::class,"deletingbloodrequest"                ]);
