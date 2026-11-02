<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatController;
use App\Models\Cat;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome', [
    'total' => Cat::count(),
    'vaccinated' => Cat::where('vaccinated', true)->count(),
    'latest' => Cat::latest()->first(),
]));

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('cats', CatController::class);
});
