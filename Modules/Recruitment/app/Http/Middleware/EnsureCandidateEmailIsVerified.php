<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureCandidateEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard === null) {
            $guard = 'candidate';
        }

        $user = Auth::guard($guard)->user();

        // If this is the verification notice route and the user is verified, redirect to dashboard
        if ($request->routeIs('candidate.verification.notice') && $user && $user->hasVerifiedEmail()) {
            return redirect()->route('candidate.dashboard');
        }

        if (
            !$user ||
            ($user instanceof MustVerifyEmail &&
                !$user->hasVerifiedEmail())
        ) {
            // If this was an ajax request
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Email not verified.'], 403);
            }

            return Redirect::route('candidate.verification.notice');
        }

        return $next($request);
    }
}
