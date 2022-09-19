<?php

use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::apiResource('books', BooksController::class);

Route::get('opa', [ApiController::class, 'index']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
