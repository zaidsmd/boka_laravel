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
Route::get('/shop-ajax',[\App\Http\Controllers\ShopViewsController::class,'shopAjax'])->name('shop.ajax');
Route::get('product/{slug}',[\App\Http\Controllers\ShopViewsController::class,'single'])->name('single');
Route::get('categories/{slug}',[\App\Http\Controllers\ShopViewsController::class,'category'])->name('category');
Route::get('categories-ajax',[\App\Http\Controllers\ShopViewsController::class,'categoryAjax'])->name('category.ajax');
Route::get('new',[\App\Http\Controllers\ShopViewsController::class,'new'])->name('new');
Route::get('new-ajax',[\App\Http\Controllers\ShopViewsController::class,'newAjax'])->name('new.ajax');
Route::get('best-seller',[\App\Http\Controllers\ShopViewsController::class,'bestSeller'])->name('best-seller');
Route::get('best-seller-ajax',[\App\Http\Controllers\ShopViewsController::class,'bestSellerAjax'])->name('best-seller.ajax');
Route::get('sale',[\App\Http\Controllers\ShopViewsController::class,'sale'])->name('sale');

Route::get('/import',[\App\Http\Controllers\ImportController::class,'import']);

//  Static
Route::get('من-نحن',[\App\Http\Controllers\StaticPagesController::class,'aboutUs'])->name('static-pages.about-us');
Route::get('الشروط-الأحكام',[\App\Http\Controllers\StaticPagesController::class,'termsAndConditions'])->name('static-pages.terms-and-conditions');

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


Route::prefix('cp_admin')->group(function () {

Route::group(['prefix' => 'articles', 'controller' => \App\Http\Controllers\ArticleController::class], function () {
    Route::get('/', 'liste')->name('articles.liste');
    Route::get('/{id}/afficher', 'afficher')->name('articles.afficher');
    Route::get('/ajouter', 'ajouter')->name('articles.ajouter');
    Route::post('/', 'sauvegarder')->name('articles.sauvegarder');
    Route::get('/{id}/modifier', 'modifier')->name('articles.modifier');
    Route::put('/{id}', 'mettre_a_jour')->name('articles.mettre_a_jour');
    Route::delete('/{id}', 'supprimer')->name('articles.supprimer');
    Route::get('load/{media}', 'load')->name('articles.load');
    Route::get('/upload}', 'upload')->name('articles.upload');



});

Route::group(['prefix' => 'categories', 'controller' => \App\Http\Controllers\CategoryController::class], function () {
    Route::get('/', 'liste')->name('categories.liste');
    Route::get('/{id}/afficher', 'afficher')->name('categories.afficher');
    Route::get('/ajouter', 'ajouter')->name('categories.ajouter');
    Route::post('/', 'sauvegarder')->name('categories.sauvegarder');
    Route::get('/{id}/modifier','modifier')->name('categories.modifier');
    Route::put('/{id}', 'mettre_a_jour')->name('categories.mettre_a_jour');
    Route::delete('supprimer/{id}','supprimer')->name('categories.supprimer');
    Route::get('/categories-select', 'categories_select')->name('categories.select');

});


Route::group(['prefix' => 'utilisateurs','controller' => \App\Http\Controllers\UserController::class], function (){
    Route::get('/','liste')->name('utilisateurs.liste');
    Route::get('ajouter','ajouter')->name('utilisateurs.ajouter');
    Route::post('sauvegarder','sauvegarder')->name('utilisateurs.sauvegarder');
    Route::put('mettre_a_jour/{id}','mettre_a_jour')->name('utilisateurs.mettre_jour');
    Route::get('modifier/{id}','modifier')->name('utilisateurs.modifier');
    Route::delete('supprimer/{id}','supprimer')->name('utilisateurs.supprimer');
    Route::get('/connexion/{id}','connexion')->name('utilisateurs.connexion');
    Route::get('/ma-licence','maLicence')->name('utilisateurs.ma_licence');
});


});
