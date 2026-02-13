<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandingImageApiController;
use App\Http\Controllers\Api\ClientLogoApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\ContactMessageApiController;

Route::get('/landing-images', [LandingImageApiController::class, 'index']);
Route::get('/client-logos', [ClientLogoApiController::class, 'index']);
Route::get('/services', [ServiceApiController::class, 'index']);
Route::post('/contact-messages', [ContactMessageApiController::class, 'store']);
