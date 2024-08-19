<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/registro', [ProfileController::class, 'registerPage']);
Route::post('/registro', [ProfileController::class, 'registerValid']);
Route::get('/login', [ProfileController::class, 'loginPage']);
Route::post('/login', [ProfileController::class, 'loginValid']);
Route::get('/perfil', [ProfileController::class, 'perfil']);
Route::post('/perfil', [ProfileController::class, 'newInsert']);
Route::post('/sair', [ProfileController::class, 'sair']);
