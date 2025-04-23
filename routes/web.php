<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\DataAPI;

Route::get('/', [LoginController::class, 'index'])->name('loginview');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::post('/insert', [DataAPI::class, 'insert'])->name('insert');


Route::get('/gettoday', [DataAPI::class,'getToday'])->name('get_today');

Route::get('/getcost', [DataAPI::class,'getCost'])->name('get_cost');

Route::middleware(['auth'])->group(function (){
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/table', [TableController::class, 'index'])->name('table'); 

});