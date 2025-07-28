<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout.head', function ($view) {
            $count_order_pending_payment = 0;
            if (Auth::check()) {
                $count_order_pending_payment = Order::where('user_id', Auth::user()->id)->where('status', null)->count();
            }
            $view->with('count_order_pending_payment', $count_order_pending_payment);
        });
    }
}
