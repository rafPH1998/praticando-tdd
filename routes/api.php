<?php

use App\Http\Controllers\Api\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('books', [BooksController::class, 'index']);
Route::post('books', [BooksController::class, 'store']);
Route::get('books/{id}', [BooksController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
