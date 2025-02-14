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

    public function login(Request $request) {


        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);


        session()->put('active_link', 'dashboard');
        $user = User::where('name', $request->name)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }


        
        return back()->withErrors(['email' => 'Invalid credentials']);
    }


    public function logout() {
        Auth::logout();
        session()->invalidate();
        return redirect()->route('loginview');
    }
}
