<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCandidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated as a candidate
        if (!Auth::guard('candidate')->check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            // Store the intended URL for redirect after login
            session()->put('url.intended', url()->current());
            return redirect()->route('candidate.login');
        }

        // Add candidate info to the request for easy access
        $request->merge(['candidate' => Auth::guard('candidate')->user()]);

        return $next($request);
    }
}
