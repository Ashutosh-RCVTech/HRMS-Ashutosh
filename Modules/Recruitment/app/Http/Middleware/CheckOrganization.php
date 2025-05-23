<?php

namespace Modules\Recruitment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // app/Http/Middleware/CheckOrganization.php
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('organization')->check()) {
            return redirect()->route('organization.login');
        }
        return $next($request);
    }
}
