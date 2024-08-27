<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/registro', [ProfileController::class, 'registerPage']);
Route::post('/registro', [ProfileController::class, 'registerValid']);
Route::get('/login', [ProfileController::class, 'loginPage']);
Route::post('/login', [ProfileController::class, 'loginValid']);
Route::get('/perfil', [ProfileController::class, 'perfil']);
Route::post('/perfil', [ProfileController::class, 'newProfilePicture']);
Route::post('/sair', [ProfileController::class, 'sair']);

Route::get('/produto', [ProductController::class, 'index']);
Route::get('/pesquisa', [ProductController::class, 'search']);
Route::post('/novoproduto', [ProductController::class, 'newProduct']);
Route::post('/produto', [ProductController::class, 'buying']);
Route::post('/alteraproduto', [ProductController::class, 'chageData']);

Route::get('/carrinho', [CartController::class, 'index']);
Route::get('/remover', [CartController::class, 'remove']);
Route::post('/comprar', [CartController::class, 'buy']);