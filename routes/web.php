<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

/**
 *  User Routes
 */
Route::controller(ProfileController::class)->group(function () {
    Route::get('/registro', 'registerPage');
    Route::post('/registro', 'registerValid');
    Route::get('/login', 'loginPage');
    Route::post('/login', 'loginValid');

    Route::middleware(['auth'])->group(function () {
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
    Route::middleware(['auth'])->group(function () {
        Route::get('/carrinho', 'index');
        Route::get('/remover', 'remove');
        Route::post('/comprar', 'buy');
    });
});
