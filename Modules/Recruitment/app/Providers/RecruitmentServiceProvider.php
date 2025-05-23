<?php

namespace Modules\Recruitment\Providers;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use Modules\Recruitment\Models\JobOpening;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\JobApplication;
use Modules\Recruitment\Models\PlacementDrive;
use Modules\Recruitment\View\Components\QuizModal;
use Modules\Recruitment\View\Components\QuizStyle;
use Modules\Recruitment\Services\FileUploadService;
use Modules\Recruitment\View\Components\QuizScript;
use Modules\Recruitment\View\Components\QuizTopBar;
use Modules\Recruitment\Http\Middleware\CollegeAuth;
use Modules\Recruitment\View\Components\QuizWarning;
use Modules\Recruitment\View\Components\QuestionList;
use Modules\Recruitment\Policies\PlacementDrivePolicy;
use Modules\Recruitment\Repositories\ContactRepository;
use Modules\Recruitment\View\Components\CurrentQuestion;
use Modules\Recruitment\Repositories\CandidateRepository;
use Modules\Recruitment\Services\CandidateProfileService;
use Modules\Recruitment\View\Components\ActivityLogTable;
use Modules\Recruitment\Repositories\JobOpeningRepository;
use Modules\Recruitment\View\Components\ActivityLogFilter;
use Modules\Recruitment\Repositories\EloquentUserRepository;
use Modules\Recruitment\Repositories\UserRepositoryInterface;
use Modules\Recruitment\View\Components\CandidateGuestLayout;
use Modules\Recruitment\Repositories\JobApplicationRepository;
use Modules\Recruitment\Services\Interfaces\IFileUploadService;
use Modules\Recruitment\View\Components\ActivityLogFilterModal;
use Modules\Recruitment\Repositories\ContactRepositoryInterface;
use Modules\Recruitment\Services\CandidateJobApplicationService;
use Modules\Recruitment\Services\Interfaces\ICandidateProfileService;
use Modules\Recruitment\Http\Middleware\EnsureCandidateEmailIsVerified;
use Modules\Recruitment\Repositories\CandidateJobApplicationRepository;
use Modules\Recruitment\Repositories\CandidateJobApplicationRepositoryInterface;
use Modules\Recruitment\View\Components\CandidateImportForm;


class RecruitmentServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Recruitment';

    protected string $nameLower = 'recruitment';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(module_path('Recruitment', 'resources/views'), 'Recruitment');
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));

        // Register middleware
        $this->app['router']->aliasMiddleware('college.auth', \Modules\Recruitment\Http\Middleware\CollegeAuth::class);

        Blade::component('candidate-guest-layout', CandidateGuestLayout::class);

        Blade::component('activity-log-activity-filters', ActivityLogFilter::class);
        Blade::component('activity-log-activity-filter-modal', ActivityLogFilterModal::class);

        Blade::component('activity-log-table', ActivityLogTable::class);
        Blade::component('mcq-current-question', CurrentQuestion::class);
        Blade::component('mcq-questions-list', QuestionList::class);

        Blade::component('mcq-top-bar', QuizTopBar::class);
        Blade::component('mcq-warning', QuizWarning::class);

        Blade::component('mcq-modals', QuizModal::class);
        Blade::component('mcq-scripts', QuizScript::class);
        Blade::component('mcq-styles', QuizStyle::class);
        Blade::component('college-bulk-import-import-form', CandidateImportForm::class);

        // Register Policies
        Gate::policy(PlacementDrive::class, PlacementDrivePolicy::class);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(ICandidateProfileService::class, CandidateProfileService::class);
        $this->app->bind(IFileUploadService::class, FileUploadService::class);

        // Register CollegeService binding
        $this->app->bind(
            \Modules\Recruitment\Services\Interfaces\CollegeServiceInterface::class,
            \Modules\Recruitment\Services\CollegeService::class
        );


        $this->app->bind(
            \Modules\Recruitment\Services\Interfaces\IQuizAssignmentService::class,
            \Modules\Recruitment\Services\QuizAssignmentService::class //   concrete class
        );

        // Register PlacementDriveServiceInterface binding
        $this->app->bind(
            \Modules\Recruitment\Services\Interfaces\PlacementDriveServiceInterface::class,
            \Modules\Recruitment\Services\PlacementDriveService::class
        );

        // Register PlacementDriveRepositoryInterface binding
        $this->app->bind(
            \Modules\Recruitment\Repositories\Interfaces\College\PlacementDriveRepositoryInterface::class,
            \Modules\Recruitment\Repositories\PlacementDriveRepository::class
        );



        // Register middleware
        $this->app['router']->aliasMiddleware('checkProfileCompletion', \Modules\Recruitment\Http\Middleware\CheckProfileCompletion::class);


        $this->app['router']->aliasMiddleware('verified', EnsureCandidateEmailIsVerified::class);
        // Register Role Repository and Service
        $this->app->bind(
            \Modules\Recruitment\Repositories\Interfaces\RoleRepositoryInterface::class,
            \Modules\Recruitment\Repositories\RoleRepository::class
        );

        // Register Permission Repository and Service
        $this->app->bind(
            \Modules\Recruitment\Repositories\Interfaces\PermissionRepositoryInterface::class,
            \Modules\Recruitment\Repositories\PermissionRepository::class
        );

        // Bind the JobOpeningRepository
        $this->app->bind(JobOpeningRepository::class, function ($app) {
            return new JobOpeningRepository(new JobOpening());
        });

        // Bind the JobApplicationRepository
        $this->app->bind(JobApplicationRepository::class, function ($app) {
            return new JobApplicationRepository(new JobApplication());
        });

        // Bind the CandidateRepository
        $this->app->bind(CandidateRepository::class, function ($app) {
            return new CandidateRepository(new CandidateUser());
        });

        // Bind the JobApplicationRepository implementation to its interface
        $this->app->bind(CandidateJobApplicationRepositoryInterface::class, CandidateJobApplicationRepository::class);

        // Register the JobApplicationService
        $this->app->singleton(CandidateJobApplicationService::class, function ($app) {
            return new CandidateJobApplicationService(
                $app->make(CandidateJobApplicationRepositoryInterface::class)
            );
        });



        // Bind the contact repository interface to its implementation
        $this->app->bind(
            ContactRepositoryInterface::class,
            ContactRepository::class
        );
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $relativeConfigPath = config('modules.paths.generator.config.path');
        $configPath = module_path($this->name, $relativeConfigPath);

        // if (is_dir($configPath)) {
        //     $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

        //     foreach ($iterator as $file) {
        //         if ($file->isFile() && $file->getExtension() === 'php') {
        //             $relativePath = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
        //             $configKey = $this->nameLower . '.' . str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $relativePath);
        //             $key = ($relativePath === 'config.php') ? $this->nameLower : $configKey;

        //             $this->publishes([$file->getPathname() => config_path($relativePath)], 'config');
        //             $this->mergeConfigFrom($file->getPathname(), $key);
        //         }
        //     }
        // }
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        $componentNamespace = $this->module_namespace($this->name, $this->app_path(config('modules.paths.generator.component-class.path')));
        Blade::componentNamespace($componentNamespace, $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            JobOpeningRepository::class,
            JobApplicationRepository::class,
            CandidateRepository::class,
        ];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->nameLower)) {
                $paths[] = $path . '/modules/' . $this->nameLower;
            }
        }

        return $paths;
    }
}
