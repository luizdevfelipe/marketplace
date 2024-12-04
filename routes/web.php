<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 *  Home Routes
 */
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
});

/**
 *  Auth Routes
 */
Route::controller(AuthController::class)->group(function () {
    Route::middleware(['auth', 'alreadyVerified'])->group(function () {

        Route::get('/email-verify', 'emailVerifyView')
            ->name('verification.notice');

        Route::get('/email-verify/{id}/{hash}', 'verifyEmail')
            ->middleware('signed')->name('verification.verify');

        Route::post('/email/verification-resent', 'resentVerificationEmail')
            ->middleware('throttle:3,2')->name('verification.send');
    });
});

/**
 *  User Routes
 */
Route::controller(ProfileController::class)->group(function () {
    Route::get('/registro', 'registerPage');
    Route::post('/registro', 'registerValid');
    Route::get('/login', 'loginPage')->name('login');
    Route::post('/login', 'loginValid');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/perfil', 'perfil');
        Route::post('/perfil', 'newProfilePicture');
        Route::post('/sair', 'sair');
    });
});

/**
 *  Products Routes
 */
Route::controller(ProductController::class)->group(function () {
    Route::get('/produto', 'index');
    Route::get('/pesquisa', 'search');
    Route::post('/novoproduto', 'newProduct');
    Route::post('/produto', 'buying');
    Route::post('/alteraproduto', 'chageData');
});

/**
 *  Cart Routes
 */
Route::controller(CartController::class)->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/carrinho', 'index');
        Route::get('/remover', 'remove');
        Route::post('/comprar', 'buy');
    });
});
