<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('auth.login');
Route::group(['middleware' => 'auth:web'], function () {
    //  Profile
    Route::post('my-account', [\App\Http\Controllers\ProfileController::class, 'updateAccountInfo'])->name('profile.update-account-info');
    Route::post('shipping-address', [\App\Http\Controllers\ProfileController::class, 'updateShippingAddress'])->name('profile.update-shipping-address');
    Route::post('invoicing-address', [\App\Http\Controllers\ProfileController::class, 'updateInvoicingAddress'])->name('profile.update-invoicing-address');

    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');

});

//  Views
Route::get('/', [\App\Http\Controllers\ShopViewsController::class, 'home'])->name('home');
Route::get('/cart', [\App\Http\Controllers\ShopViewsController::class, 'cart'])->name('cart.show');
Route::get('my-account', [\App\Http\Controllers\ShopViewsController::class, 'myAccount'])->name('my-account');
Route::get('checkout', [\App\Http\Controllers\ShopViewsController::class, 'checkout'])->name('checkout');


Route::get('/add-to-cart', [\App\Http\Controllers\CartController::class, 'addLine'])->name('cart.add-line');
Route::get('/cart-canvas', [\App\Http\Controllers\CartController::class, 'cartOffCanvas'])->name('cart.cart-off-canvas');
Route::delete('/cart-ligne', [\App\Http\Controllers\CartController::class, 'deleteCartLigne'])->name('cart.delete-cart-ligne');
Route::post('/cart-item-quantity', [\App\Http\Controllers\CartController::class, 'updateLineQuantity'])->name('cart.update-line-quantity');
Route::delete('/cart-line-delete', [\App\Http\Controllers\CartController::class, 'deleteLine'])->name('cart.line-delete');
Route::post('/cart-city', [\App\Http\Controllers\CartController::class, 'updateCartCity'])->name('cart.line-delete');

