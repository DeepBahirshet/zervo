<?php

use App\Http\Controllers\Api\Applications\StoreController;
use App\Http\Controllers\Api\Requirements\CreateController;
use App\Http\Controllers\Api\Requirements\IndexController;
use App\Http\Controllers\Applications\AcceptController;
use App\Http\Controllers\Applications\RejectController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {

    Route::get('/requirements', IndexController::class)->name('api.requirements');
    
    Route::post('/requirements', CreateController::class)->name('api.requirements.store');

    Route::post('/requirements/{requirement}/apply', StoreController::class)->name('api.requirements.apply');

    Route::patch('/applications/{application}/accept', AcceptController::class);
    
    Route::patch('/applications/{application}/reject', RejectController::class);
});