<?php

use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatController;
use App\Models\Cat;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome', [
    'total' => Cat::available()->count(),
    'vaccinated' => Cat::available()->where('vaccinated', true)->count(),
    'latest' => Cat::available()->latest()->first(),
]));

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');

    Route::middleware('can:staff')->group(function () {
        Route::resource('cats', CatController::class)->except(['index', 'show']);
    });

    Route::middleware('can:adopter')->group(function () {
        Route::resource('adoptions', AdoptionController::class)->only(['create', 'store', 'edit', 'update']);
        Route::post('/adoptions/{adoption}/confirm', [AdoptionController::class, 'confirm'])->name('adoptions.confirm');
    });

    Route::resource('cats', CatController::class)->only(['index', 'show']);
});
