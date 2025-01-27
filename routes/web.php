<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EmailVerificationController;
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
 *  Fallback Route (404)
 */
Route::fallback(function () {
    return redirect('/');
});

/**
 *  Auth Routes
 */
Route::controller(EmailVerificationController::class)->group(function () {
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
Route::controller(AuthController::class)->group(function () {
    Route::get('/registro', 'registerPage');
    Route::post('/registro', 'registerValid');
});

Route::controller(ProfileController::class)->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/perfil/load', 'load');
        Route::get('/perfil', 'perfil');
        Route::post('/perfil', 'newProfilePicture');
        Route::get('/perfil/two-factor-manage', function () {
            return view('user.manage2fa');
        });
        Route::post('/sair', 'sair');
    });

/**
 *  Products Routes
 */
Route::name('produto.')->prefix('produto')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/{productId}', 'index')->whereNumber('productId')->name('index');
        Route::get('/search/{query}', 'search')->whereAlphaNumeric('query')->name('search');
        Route::post('/new', 'newProduct')->name('new');
        Route::post('/{productId}/buy', 'buying')->whereNumber('productId')->name('buy');
        Route::post('/{productId}/modify', 'chageData')->whereNumber('productId')->name('modify');
    });
});

/**
 *  Cart Routes
 */
Route::controller(CartController::class)->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/carrinho', 'index');
        Route::delete('/carrinho/{id}', 'remove')->whereNumber('id')->name('remove');
        Route::post('/carrinho', 'generatePayment');
        Route::put('/carrinho/{id}', 'changeQuantity')->whereNumber('id')->name('changeQuantity');

        Route::get('/carrinho/success', 'success')->name('mercadopago.success');
        Route::get('/carrinho/fail', 'fail')->name('mercadopago.failed');
    });
});
