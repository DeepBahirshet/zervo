<?php

use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RequirementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function() {

    Route::get('/', function() {
        return Inertia::render('Auth/Login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/requirements',[RequirementController::class, 'index'])->name('requirements.index');

    Route::get('/requirements/create', [RequirementController::class, 'create'])->name('requirements.create');

    Route::get('/requirements/{requirement}', [RequirementController::class, 'show'])
    ->name('requirements.show');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/index', AdminIndexController::class)
            ->name('index');

    });