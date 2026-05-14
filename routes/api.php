<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController; // Sesuaikan jika nama filenya ProductApiController

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Pastikan nama class-nya sama dengan file yang kamu buat (ProductController atau ProductApiController)
    Route::post('/product', [ProductController::class, 'store']); 
});

Route::get('/product/{id}', [ProductController::class, 'show']);

Route::post('/login', [AuthController::class, 'getToken']);