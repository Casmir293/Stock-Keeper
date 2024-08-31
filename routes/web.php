<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('sign-up', [RegisterController::class, 'index'])->name('signup');
Route::post('/sign-up', [RegisterController::class, 'store'])->name('signup.store');

// Route::get('sign-in', function () {
//     return Inertia::render('auth/SignIn');
// })->name('signin');

Route::get('/sign-in', [LoginController::class, 'index'])->name('signin');
Route::post('/sign-in', [LoginController::class, 'store'])->name('signin.store');
