<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/SignIn');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return to_route('home')->with('flash', ['success' => 'Logged in successfully!']);
        }

        // return back()->withErrors([
        //     'message' => 'The provided credentials do not match our records.',
        // ])->withInput();

        return back()->with('flash', ['error' => 'Invalid email/password'])->withInput();
    }
}
