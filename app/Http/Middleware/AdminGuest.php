<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            // If the candidate is already authenticated,
            // redirect them to the candidate's dashboard or another appropriate route.
            return redirect()->route('admin.dashboard');
        }



        // if (Auth::guard('admin')->check()) {
        //     // If the candidate is already authenticated,
        //     // redirect them to the candidate's dashboard or another appropriate route.
        //     return redirect()->route('admin.dashboard');
        // }
        return $next($request);
    }
}
