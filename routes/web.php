<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use Illuminate\Auth\Events\Login;



Route::get('/', [LoginController::class, 'index']);


Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboard');
});


