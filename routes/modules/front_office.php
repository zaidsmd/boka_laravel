<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('auth.login');
Route::group(['middleware' => 'auth:web'], function () {
    //  Profile
    Route::post('my-account', [\App\Http\Controllers\ProfileController::class, 'updateAccountInfo'])->name('profile.update-account-info');
    Route::post('shipping-address', [\App\Http\Controllers\ProfileController::class, 'updateShippingAddress'])->name('profile.update-shipping-address');
    Route::post('invoicing-address', [\App\Http\Controllers\ProfileController::class, 'updateInvoicingAddress'])->name('profile.update-invoicing-address');
    Route::get('orders/{number}',[\App\Http\Controllers\OrderController::class,'show'])->name('order.show');

    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');


});

//  Views
Route::get('/', [\App\Http\Controllers\ShopViewsController::class, 'home'])->name('home');
Route::get('/cart', [\App\Http\Controllers\ShopViewsController::class, 'cart'])->name('cart.show');
Route::get('my-account', [\App\Http\Controllers\ShopViewsController::class, 'myAccount'])->name('my-account');
Route::get('checkout', [\App\Http\Controllers\ShopViewsController::class, 'checkout'])->name('checkout');
Route::get('/shop',[\App\Http\Controllers\ShopViewsController::class,'shop'])->name('shop');
Route::get('/shop/tags/{selected_tag}',[\App\Http\Controllers\ShopViewsController::class,'shop'])->name('shop.tags');
Route::get('/shop/categories/{selected_category}',[\App\Http\Controllers\ShopViewsController::class,'shop'])->name('shop.categories');
Route::get('/shop/search/{search}',[\App\Http\Controllers\ShopViewsController::class,'shop'])->name('shop.search');
Route::get('/shop/sort/{sort}',[\App\Http\Controllers\ShopViewsController::class,'shop'])->name('shop.sort');
Route::get('/shop/sale/{sale}',[\App\Http\Controllers\ShopViewsController::class,'shop'])->name('shop.sale');
Route::get('/shop-ajax',[\App\Http\Controllers\ShopViewsController::class,'shopAjax'])->name('shop.ajax');
Route::get('product/{slug}',[\App\Http\Controllers\ShopViewsController::class,'single'])->name('single');
Route::get('categories/{slug}',[\App\Http\Controllers\ShopViewsController::class,'category'])->name('category');
Route::get('categories-ajax',[\App\Http\Controllers\ShopViewsController::class,'categoryAjax'])->name('category.ajax');
Route::get('new',[\App\Http\Controllers\ShopViewsController::class,'new'])->name('new');
Route::get('new-ajax',[\App\Http\Controllers\ShopViewsController::class,'newAjax'])->name('new.ajax');
Route::get('best-seller',[\App\Http\Controllers\ShopViewsController::class,'bestSeller'])->name('best-seller');
Route::get('best-seller-ajax',[\App\Http\Controllers\ShopViewsController::class,'bestSellerAjax'])->name('best-seller.ajax');
Route::get('sale',[\App\Http\Controllers\ShopViewsController::class,'sale'])->name('sale');

Route::get('/import/{file}',[\App\Http\Controllers\ImportController::class,'import']);

//  Static
Route::get('من-نحن',[\App\Http\Controllers\StaticPagesController::class,'aboutUs'])->name('static-pages.about-us');
Route::get('الشروط-الأحكام',[\App\Http\Controllers\StaticPagesController::class,'termsAndConditions'])->name('static-pages.terms-and-conditions');

Route::get('/add-to-cart', [\App\Http\Controllers\CartController::class, 'addLine'])->name('cart.add-line');
Route::get('/add-to-members-order', [\App\Http\Controllers\CartController::class, 'addMemberOrder'])->name('cart.add-member-order');
Route::get('/add-to-cart-single', [\App\Http\Controllers\CartController::class, 'addLineFromSingle'])->name('cart.add-line');
Route::get('/cart-canvas', [\App\Http\Controllers\CartController::class, 'cartOffCanvas'])->name('cart.cart-off-canvas');
Route::delete('/cart-ligne', [\App\Http\Controllers\CartController::class, 'deleteCartLigne'])->name('cart.delete-cart-ligne');
Route::post('/cart-item-quantity', [\App\Http\Controllers\CartController::class, 'updateLineQuantity'])->name('cart.update-line-quantity');
Route::delete('/cart-line-delete', [\App\Http\Controllers\CartController::class, 'deleteLine'])->name('cart.line-delete');
Route::post('/cart-city', [\App\Http\Controllers\CartController::class, 'updateCartCity'])->name('cart.line-delete');

Route::POST('checkout', [\App\Http\Controllers\OrderController::class, 'completeOrder'])->name('complete-checkout');
Route::get('checkout/confirmation/{number}', [\App\Http\Controllers\OrderController::class, 'orderConfirmation'])->name('order.confirmations');

Route::post('/pay-ok', [\App\Http\Controllers\OrderController::class, 'payOk'])->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)->name('cmi-callback-ok');
Route::post('/pay-failed', [\App\Http\Controllers\OrderController::class, 'payOk'])->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)->name('cmi-callback-failed');
Route::post('/cmi-callback',[\App\Http\Controllers\OrderController::class,'cmiCallback'])->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)->name('cmi-callback');
