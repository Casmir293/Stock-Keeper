<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StockController;

Route::middleware('auth')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('home');
        Route::post('/', [StockController::class, 'store'])->name('home.store');
        Route::put('/{product_id}', [StockController::class, 'update'])->name('home.update');
        Route::delete('/{product_id}', [StockController::class, 'destroy'])->name('home.destroy');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('noAuth')->group(function () {
        Route::get('/signup', [RegisterController::class, 'index'])->name('signup');
        Route::post('/signup', [RegisterController::class, 'store'])->name('signup.store');
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
