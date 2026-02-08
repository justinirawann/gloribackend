<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingImageController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/landing-images', [LandingImageController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::post('/landing-images', [LandingImageController::class, 'store']);
    Route::delete('/landing-images/{id}', [LandingImageController::class, 'destroy']);
});
