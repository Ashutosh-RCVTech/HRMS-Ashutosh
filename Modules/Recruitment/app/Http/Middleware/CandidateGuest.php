<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = 'candidate')
    {
        // Clear any existing sessions from other guards
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        if (Auth::guard('college')->check()) {
            Auth::guard('college')->logout();
        }

        // If the candidate is already authenticated
        if (Auth::guard($guard)->check()) {
            // Get the intended URL from the session
            $intended = session()->get('url.intended');

            // If there's an intended URL and it's a candidate route, redirect there
            if ($intended && str_contains($intended, '/candidate/')) {
                session()->forget('url.intended');
                return redirect($intended);
            }

            // Otherwise redirect to the candidate dashboard
            return redirect()->route('candidate.dashboard');
        }

        return $next($request);
    }
}
