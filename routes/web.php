<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminServicePricingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;


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


Route::middleware(['auth', 'check_status'])->group(function() {
    
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('payment/{order}', [PaymentController::class, 'payment'])->name('payment.vnpay');
    Route::get("checkout/complete/{orderId}", [PaymentController::class, "complete"])->name("checkout.complete");
    Route::post('/orders/{order}/pay-by-balance', [OrderController::class, 'payByBalance'])->name('orders.payByBalance');

    //profile
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::post('/profile/orders/{id}/cancel', [ProfileController::class, 'cancel'])->name('profile.orders.cancel');

    // Nạp tiền
    Route::post('/deposit', [ProfileController::class, 'deposit'])->name('payment.deposit');
    Route::get('/deposit/complete', [ProfileController::class, 'depositComplete'])->name('payment.deposit.complete');
    Route::get('/profile/payment-history', [ProfileController::class, 'depositHistory'])->name('profile.payment_history');

});

Route::middleware(['auth', 'admin', 'check_status'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [HomeAdminController::class, 'index'])->name('admin');
        Route::resource('users', AdminUserController::class);
        Route::patch('/users/{id}/lock', [AdminUserController::class, 'lock'])->name('users.lock');
        Route::patch('/users/{id}/unlock', [AdminUserController::class, 'unlock'])->name('users.unlock');

        Route::resource('services', AdminServiceController::class);
        Route::resource('servicesPricing', AdminServicePricingController::class);

        Route::get('/order-approve', [AdminOrderController::class, 'orderOk'])->name('orderOk');
        Route::get('/order-pending', [AdminOrderController::class, 'orderPending'])->name('orderPending');
        Route::get('/order-cancel', [AdminOrderController::class, 'orderCancel'])->name('orderCancel');
        Route::get('/order-detail/{id}', [AdminOrderController::class, 'orderDetail'])->name('orderDetail');
        Route::post('/orders/{id}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');

    });
});