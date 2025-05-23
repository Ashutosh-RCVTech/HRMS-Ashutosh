<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = 'web')
    {
        // Clear any existing sessions from other guards
        if (Auth::guard('college')->check()) {
            Auth::guard('college')->logout();
        }
        if (Auth::guard('candidate')->check()) {
            Auth::guard('candidate')->logout();
        }

        // If the admin is already authenticated
        if (Auth::guard($guard)->check()) {
            // Get the intended URL from the session
            $intended = session()->get('url.intended');

            // If there's an intended URL and it's an admin route, redirect there
            if ($intended && str_contains($intended, '/admin/')) {
                session()->forget('url.intended');
                return redirect($intended);
            }

            // Otherwise redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
} 