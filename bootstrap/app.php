<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\ServiceAccess;
use Illuminate\Foundation\Application;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Modules\Recruitment\Http\Middleware\CheckCandidate;
use App\Http\Middleware\CheckCollegePlacementAcceptance;
use Modules\Recruitment\Http\Middleware\CheckOrganization;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // 'service-access' => ServiceAccess::class,
            'checkCandidate' => CheckCandidate::class,
            'checkOrganization' => CheckOrganization::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \App\Http\Middleware\UserPermission::class,
            'candidate-guest' => Modules\Recruitment\Http\Middleware\CandidateGuest::class,
            'admin-check' => \App\Http\Middleware\AdminAuth::class,
            'admin-guest' => \App\Http\Middleware\AdminGuest::class,
            'check-college-placement-acceptance' => \App\Http\Middleware\CheckCollegePlacementAcceptance::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
