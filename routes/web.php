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
Route::get('/shop',[\App\Http\Controllers\ShopViewsController::class,'shop'])->name('shop');
Route::get('product/{slug}',[\App\Http\Controllers\ShopViewsController::class,'single'])->name('single');

Route::get('/import',[\App\Http\Controllers\ImportController::class,'import']);

Route::get('/add-to-cart', [\App\Http\Controllers\CartController::class, 'addLine'])->name('cart.add-line');
Route::get('/add-to-cart-single', [\App\Http\Controllers\CartController::class, 'addLineFromSingle'])->name('cart.add-line');
Route::get('/cart-canvas', [\App\Http\Controllers\CartController::class, 'cartOffCanvas'])->name('cart.cart-off-canvas');
Route::delete('/cart-ligne', [\App\Http\Controllers\CartController::class, 'deleteCartLigne'])->name('cart.delete-cart-ligne');
Route::post('/cart-item-quantity', [\App\Http\Controllers\CartController::class, 'updateLineQuantity'])->name('cart.update-line-quantity');
Route::delete('/cart-line-delete', [\App\Http\Controllers\CartController::class, 'deleteLine'])->name('cart.line-delete');
Route::post('/cart-city', [\App\Http\Controllers\CartController::class, 'updateCartCity'])->name('cart.line-delete');

Route::POST('checkout', [\App\Http\Controllers\OrderController::class, 'completeOrder'])->name('complete-checkout');
Route::get('checkout/confirmation/{number}', [\App\Http\Controllers\OrderController::class, 'orderConfirmation'])->name('order.confirmations');



//admin routes

// product

//Route::get('/admin', [\App\Http\Controllers\ArticleController::class, 'index'])->name('index');



Route::group(['prefix' => 'articles', 'controller' => \App\Http\Controllers\ArticleController::class], function () {
    Route::get('/', 'liste')->name('articles.liste');
    Route::get('/{id}/afficher', 'afficher')->name('articles.afficher');
    Route::get('/ajouter', 'ajouter')->name('articles.ajouter');
    Route::post('/', 'sauvegarder')->name('articles.sauvegarder');
    Route::get('/{id}/modifier', 'modifier')->name('articles.modifier');
    Route::put('/{id}', 'mettre_a_jour')->name('articles.mettre_a_jour');
    Route::delete('/articles/{article}', 'supprimer')->name('articles.supprimer');

});

Route::group(['prefix' => 'categories', 'controller' => \App\Http\Controllers\CategoryController::class], function () {
    Route::get('/', 'liste')->name('categories.liste');
    Route::get('/{id}/afficher', 'afficher')->name('categories.afficher');
    Route::get('/ajouter', 'ajouter')->name('categories.ajouter');
    Route::post('/', 'sauvegarder')->name('categories.sauvegarder');
    Route::get('/{id}/modifier','modifier')->name('categories.modifier');
    Route::put('/{id}', 'mettre_a_jour')->name('categories.mettre_a_jour');
    Route::delete('/categories/{category}', 'supprimer')->name('categories.supprimer');
    Route::get('/categories-select', 'categories_select')->name('categories.select');

});

