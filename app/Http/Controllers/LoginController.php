<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;


class LoginController extends Controller
{
    public function index() {
        return view('pages.login');
    }

    public function login($request) {


        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard'); // Redirect to a protected page
        }

        return back()->withErrors(['email' => 'Invalid credentials']);


    }
}
