<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Todo\CreateController;
use App\Http\Controllers\Testecontroller;
use Illuminate\Support\Facades\Route;

Route::get('/teste', [Testecontroller::class, 'index']);
Route::post('/teste', [Testecontroller::class, 'store'])->name('teste.store');

Route::post('register', RegisterController::class)->name('register');
Route::get('home', RegisterController::class)->name('home');

Route::middleware('auth')->group(function() {
    Route::get('todo', [CreateController::class, 'index'])->name('todo.index');
    Route::post('todo', [CreateController::class, 'store'])->name('todo.store');
    Route::put('todo/{todo}', [CreateController::class, 'update'])->name('todo.update');
    Route::delete('todo/{todo}', [CreateController::class, 'destroy'])->name('todo.destroy');
});