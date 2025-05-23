<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollegeAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Clear any existing sessions from other guards
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        if (Auth::guard('candidate')->check()) {
            Auth::guard('candidate')->logout();
        }

        if (!Auth::guard('college')->check()) {
            return redirect()->route('college.login');
        }

        $college = Auth::guard('college')->user();

        if (!$college->is_active) {
            Auth::guard('college')->logout();
            return redirect()->route('college.login')
                ->with('error', 'Your account has been deactivated. Please contact support.');
        }

        if (!$college->is_verified && !$request->is('college/email/*')) {
            return redirect()->route('college.verification.notice')
                ->with('warning', 'Please verify your email address to access your account.');
        }

        return $next($request);
    }
}
