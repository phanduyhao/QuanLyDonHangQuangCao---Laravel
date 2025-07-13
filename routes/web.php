<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;


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
