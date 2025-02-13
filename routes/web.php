<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;




Route::get('/', [LoginController::class, 'index'])->name('loginview');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboard');
})->name('dashboard');


