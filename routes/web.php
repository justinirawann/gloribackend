<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingImageController;
use App\Http\Controllers\ClientLogoController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::prefix('landing-images')->name('landing-images.')->group(function () {
        Route::get('/', [LandingImageController::class, 'index'])->name('index');
        Route::post('/', [LandingImageController::class, 'store'])->name('store');
        Route::put('/{landingImage}', [LandingImageController::class, 'update'])->name('update');
        Route::delete('/{landingImage}', [LandingImageController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('client-logos')->name('client-logos.')->group(function () {
        Route::get('/', [ClientLogoController::class, 'index'])->name('index');
        Route::post('/', [ClientLogoController::class, 'store'])->name('store');
        Route::delete('/{clientLogo}', [ClientLogoController::class, 'destroy'])->name('destroy');
    });
});
