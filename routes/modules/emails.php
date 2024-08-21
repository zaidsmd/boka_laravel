<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\PasswordSetupController;
use Illuminate\Support\Facades\Route;


//Registration
Route::get('/set-password/{token}', [PasswordSetupController::class, 'showForm'])->name('password.set');
Route::post('/set-password', [PasswordSetupController::class, 'setPassword'])->name('password.update');
Route::post('/register', [PasswordSetupController::class, 'register'])->name('register');

//Reset Password
Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController ::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.reset.update');


//Order Confirmation
