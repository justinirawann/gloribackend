<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandingImageApiController;
use App\Http\Controllers\Api\ClientLogoApiController;

Route::get('/landing-images', [LandingImageApiController::class, 'index']);
Route::get('/client-logos', [ClientLogoApiController::class, 'index']);
