<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home')->middleware('auth');

Route::middleware('noAuth')->group(function () {
        Route::get('/signup', [RegisterController::class, 'index'])->name('signup');
        Route::post('/signup', [RegisterController::class, 'store'])->name('signup.store');
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
