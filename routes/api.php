<?php

use App\Http\Controllers\Admin\Requirements\ApproveController;
use App\Http\Controllers\Api\Applications\StoreController;
use App\Http\Controllers\Api\Requirements\CreateController;
use App\Http\Controllers\Api\Requirements\IndexController;
use App\Http\Controllers\Api\Admin\Requirements\IndexController as AdminRequirementIndexController;
use App\Http\Controllers\Applications\AcceptController;
use App\Http\Controllers\Applications\RejectController;
use \App\Http\Controllers\Admin\Requirements\RejectController as AdminRequirementRejectController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->name('api.')->group(function() {

    Route::get('/requirements', IndexController::class)->name('requirements');
    
    Route::post('/requirements', CreateController::class)->name('requirements.store');

    Route::post('/requirements/{requirement}/apply', StoreController::class)->name('requirements.apply');

    Route::patch('/applications/{application}/accept', AcceptController::class);
    
    Route::patch('/applications/{application}/reject', RejectController::class);

    Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::patch('/requirements/{requirement}/approve', ApproveController::class)->name('requirements.approve');

        Route::patch('/requirements/{requirement}/reject', AdminRequirementRejectController::class)->name('requirements.reject');

        Route::get('/requirements', AdminRequirementIndexController::class)->name('requirements');
    });
});