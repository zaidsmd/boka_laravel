<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/add-to-cart', function () {
    return response('success');
});
Route::view('my-account','account')->name('my-account');
