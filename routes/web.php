<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('sign-up', [RegisterController::class, 'index'])->name('signup');

Route::post('/sign-up', [RegisterController::class, 'store'])->name('signup.store');

Route::get('sign-in', function () {
    return Inertia::render('auth/SignIn');
})->name('signin');
