<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status === 'inactive') {
            return response()->view('account_block', [
                'reason' => Auth::user()->reason_inactive,
                'title' => 'Tài khoản bị khóa',
            ]);
        }

        return $next($request);
    }
}
