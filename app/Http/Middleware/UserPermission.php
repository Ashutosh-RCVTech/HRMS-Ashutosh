<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        $user = auth()->user();

        // Get user roles
        $userRoles = $user->getRoleNames();

        // Check if the user is an admin or has the specific permission
        if ($userRoles->contains('admin') || $this->hasPermissionForRoles($permission, $userRoles)) {
            return $next($request);
        }

        // If no permission is found, show unauthorized view
        return response()->view('errors.unauthorized', [], 403);
    }

    /**
     * Check if any of the user's roles have the required permission
     *
     * @param string $permission
     * @param \Illuminate\Support\Collection $userRoles
     * @return bool
     */
    protected function hasPermissionForRoles(string $permission, $userRoles): bool
    {
        // Get all roles for the user
        foreach ($userRoles as $role) {
            // Check if the role has the specific permission
            $hasPermission = \Spatie\Permission\Models\Role::findByName($role)
                ->permissions()
                ->where('name', $permission)
                ->exists();

            if ($hasPermission) {
                return true;
            }
        }

        return false;
    }
}
