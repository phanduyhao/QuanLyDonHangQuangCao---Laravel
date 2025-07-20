<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminServicePricingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;


Route::get( '/', [HomeController::class, 'home'])->name(name: 'home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::get('/showRegister', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPass'])->name('showForgotPass');
Route::post('/forgot-password', [AuthController::class, 'sendMailForgotPass'])->name('sendMailForgotPass');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('resetPassword');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('postResetPassword');
// routes/web.php
Route::get('/api/services/{id}', [HomeController::class, 'showService']);
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/services/{id}/pricings', [ServiceController::class, 'getPricings'])->name('services.pricings');


Route::middleware(['auth'])->group(function() {
    
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [HomeAdminController::class, 'index'])->name('admin');
        Route::resource('users', AdminUserController::class);
        Route::resource('services', AdminServiceController::class);
        Route::resource('servicesPricing', AdminServicePricingController::class);

    });
});