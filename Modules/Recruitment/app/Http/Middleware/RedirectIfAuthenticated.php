<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards)
    {

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                if (Route::is('admin.*')) {
                    Auth::shouldUse('admin');
                    return redirect(RouteServiceProvider::ADMIN_HOME());
                }
                // elseif (Route::is('user.*')) {
                //     Auth::shouldUse('user');
                //     return redirect(RouteServiceProvider::USER_HOME());
                // }
                // elseif (Route::is('candidate.*')) {
                //     Auth::shouldUse('candidate');
                //     return redirect(RouteServiceProvider::CANDIDATE_HOME());
                // }
            }
        }

        return $next($request);
    }
}
