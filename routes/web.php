<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthCheckMiddleware;

Route::withoutMiddleware([AuthCheckMiddleware::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/login', [AuthController::class, 'postLogin']);
});

Route::middleware([AuthCheckMiddleware::class])->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::get('/products/{id}/edit', [ProductController::class, 'show']);
    Route::post('/products/{id}/update', [ProductController::class, 'update']);
    Route::get('/products/{id}/delete', [ProductController::class, 'destroy']);
    Route::post('/products/export-to-excel', [ProductController::class, 'exportToExcel']);

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'profileUpdate']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
