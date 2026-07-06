<?php

use App\Http\Controllers\RequirementController;
use Illuminate\Support\Facades\Route;

Route::get('/requirements', [RequirementController::class, 'index'])->name('requirements');

Route::get('/requirements/{requirement}', [RequirementController::class, 'show'])
    ->name('requirements.show');