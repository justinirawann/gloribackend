<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandingImageApiController;
use App\Http\Controllers\Api\ClientLogoApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\ContactMessageApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\AboutImageApiController;
use App\Http\Controllers\Api\ContactInfoApiController;

Route::get('/landing-images', [LandingImageApiController::class, 'index']);
Route::get('/client-logos', [ClientLogoApiController::class, 'index']);
Route::get('/services', [ServiceApiController::class, 'index']);
Route::get('/services/{id}', [ServiceApiController::class, 'show']);
Route::get('/services/{serviceId}/portfolios', [PortfolioApiController::class, 'getByService']);
Route::get('/portfolios/{id}', [PortfolioApiController::class, 'show']);
Route::get('/about-images', [AboutImageApiController::class, 'index']);
Route::get('/contact-info', [ContactInfoApiController::class, 'index']);
Route::post('/contact-messages', [ContactMessageApiController::class, 'store']);
