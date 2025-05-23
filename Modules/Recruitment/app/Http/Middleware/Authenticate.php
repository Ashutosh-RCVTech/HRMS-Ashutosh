<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request): ?string
    {


        if (!$request->expectJson()) {
            if (Route::is('admin.*')) {
                Auth::shouldUse('admin');
                return route('login');
            }
            // elseif (Route::is('user.*')) {
            //     Auth::shouldUse('user');
            //     return route('user.login');
            // }
            // elseif (Route::is('candidate.*')) {
            //     Auth::shouldUse('candidate');
            //     return route('candidate.login');
            // }
        }
        return null;
    }
}
