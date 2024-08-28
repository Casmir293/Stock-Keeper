<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('sign-up', function () {
    return Inertia::render('auth/SignUp');
});

Route::get('sign-in', function () {
    return Inertia::render('auth/SignIn');
});