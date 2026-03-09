<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingImageController;
use App\Http\Controllers\ClientLogoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PortfolioImageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AboutImageController;
use App\Http\Controllers\ContactInfoController;
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
    
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::post('/{service}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('contact-messages')->name('contact-messages.')->group(function () {
        Route::get('/', [ContactMessageController::class, 'index'])->name('index');
        Route::delete('/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('portfolios')->name('portfolios.')->group(function () {
        Route::get('/', [PortfolioController::class, 'index'])->name('index');
        Route::post('/', [PortfolioController::class, 'store'])->name('store');
        Route::post('/{portfolio}', [PortfolioController::class, 'update'])->name('update');
        Route::delete('/{portfolio}', [PortfolioController::class, 'destroy'])->name('destroy');
        
        Route::get('/{portfolio}/images', [PortfolioImageController::class, 'manage'])->name('images.manage');
        Route::post('/{portfolio}/images/upload', [PortfolioImageController::class, 'upload'])->name('images.upload');
        Route::post('/{portfolio}/images/display', [PortfolioImageController::class, 'updateDisplay'])->name('images.display');
        Route::delete('/{portfolio}/images/all', [PortfolioImageController::class, 'deleteAll'])->name('images.deleteAll');
        Route::delete('/images/{image}', [PortfolioImageController::class, 'delete'])->name('images.delete');
    });
    
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('about-images')->name('about-images.')->group(function () {
        Route::get('/', [AboutImageController::class, 'index'])->name('index');
        Route::post('/update', [AboutImageController::class, 'update'])->name('update');
    });
    
    Route::prefix('contact-info')->name('contact-info.')->group(function () {
        Route::get('/', [ContactInfoController::class, 'index'])->name('index');
        Route::post('/update', [ContactInfoController::class, 'update'])->name('update');
    });
});
