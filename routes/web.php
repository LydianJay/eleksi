<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use Illuminate\Auth\Events\Login;



Route::get('/', [LoginController::class, 'index'])->name('loginview');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboard');
})->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

