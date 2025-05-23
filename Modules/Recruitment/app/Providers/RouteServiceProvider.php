<?php

namespace Modules\Recruitment\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public static function ADMIN_HOME(): string
    {
        return '/admin/dashboard';
    }

    public static function CANDIDATE_HOME(): string
    {
        return '/candidate/dashboard';
    }

    public static function ORGANIZATION_HOME(): string
    {
        return '/organization/dashboard';
    }

    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/college/dashboard';

    protected string $name = 'Recruitment';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();

        // Configure authentication redirects
        $this->configureAuthentication();

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // $this->routes(function () {
        //     // Admin Routes
        //     Route::middleware('web')
        //         ->prefix('admin')
        //         ->name('admin.')
        //         ->group(module_path('Recruitment', '/routes/admin.php'));

        //     // College Routes
        //     Route::middleware(['web'])
        //         ->prefix('college')
        //         ->name('college.')
        //         ->group(module_path('Recruitment', '/routes/college.php'));

        //     // API Routes
        //     Route::middleware('api')
        //         ->prefix('api')
        //         ->group(module_path('Recruitment', '/routes/api.php'));
        // });
    }

    protected function configureAuthentication(): void
    {
        // Configure the authentication redirects
        config([
            'auth.defaults.guard' => 'web',
            'auth.guards.candidate.provider' => 'candidate_users',
            'auth.guards.college.provider' => 'colleges',
        ]);
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapCandidateRoutes();

        $this->mapOrganizationRoutes();

        $this->mapCollegeRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->namespace('Modules\Recruitment\Http\Controllers')
            ->group(module_path($this->name, '/routes/admin.php'));
    }

    protected function mapCandidateRoutes()
    {
        Route::middleware('web')
            ->namespace('Modules\Recruitment\Http\Controllers')
            ->group(module_path($this->name, '/routes/candidate.php'));
    }

    protected function mapOrganizationRoutes()
    {
        Route::middleware('web')
            ->namespace('Modules\Recruitment\Http\Controllers')
            ->group(module_path($this->name, '/routes/organization.php'));
    }

    protected function mapCollegeRoutes()
    {
        Route::middleware('web')
            ->namespace('Modules\Recruitment\Http\Controllers')
            ->group(module_path($this->name, '/routes/college.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(module_path($this->name, '/routes/api.php'));
    }
}
