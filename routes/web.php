<?php

use App\Http\Controllers\RegisterController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class)->name('register');
Route::get('home', RegisterController::class)->name('home');

Route::get('/', function () {
    return view('welcome');
});
