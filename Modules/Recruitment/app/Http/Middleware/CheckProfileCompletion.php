<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next)
    {
        $candidate = Auth::guard('candidate')->user();

        // List of routes that don't require profile completion
        $excludedRoutes = [
            'candidate.profile.index',
            'candidate.profile.update-basic-details',
            'candidate.profile.update-education',
            'candidate.profile.update-employment',
            'candidate.profile.update-career-profile',
            'candidate.logout'
        ];

        // if (!$candidate->profile_completed && !in_array($request->route()->getName(), $excludedRoutes)) {
        //     return redirect()->route('candidate.profile.index')
        //         ->with('message', 'Please complete your profile to access this feature.');
        // }
        if (!$candidate->profile_completed && !in_array($request->route()->getName(), $excludedRoutes)) {
            return redirect()->route('candidate.profile.index')
                ->with('warning', 'Please complete your profile to access this feature.');
        }

        return $next($request);
    }
}
