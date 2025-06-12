<?php

use App\Http\Controllers\EntryController;
use Illuminate\Support\Facades\Route;



Route::prefix('/entry')->group(function () {

    Route::get('/', [EntryController::class, 'index']);
    Route::get('/{id}', [EntryController::class, 'show']);
    Route::post('/', [EntryController::class, 'store']);
    Route::patch('/{id}', [EntryController::class, 'update']);
    Route::delete('/{id}', [EntryController::class, 'destroy']);
});


Route::get('/sumary', [EntryController::class, 'sumary']);
