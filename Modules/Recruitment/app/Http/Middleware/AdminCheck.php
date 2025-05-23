<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        // Clear any existing sessions from other guards
        if (Auth::guard('college')->check()) {
            Auth::guard('college')->logout();
        }
        if (Auth::guard('candidate')->check()) {
            Auth::guard('candidate')->logout();
        }

        if (!Auth::guard('web')->check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $admin = Auth::guard('web')->user();

        if (!$admin->is_active) {
            Auth::guard('web')->logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact support.');
        }

        return $next($request);
    }
}
