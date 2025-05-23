<?php

use Illuminate\Support\Facades\Route;
// use Modules\Recruitment\Http\Controllers\Admin\SkillController;
use Modules\Recruitment\Http\Controllers\Admin\HelpController;
use Modules\Recruitment\Http\Controllers\Admin\Placement\PlacementDriveController;
use Modules\Recruitment\Http\Controllers\Admin\RoleController;
use Modules\Recruitment\Http\Controllers\Admin\ClientController;
use Modules\Recruitment\Http\Controllers\Admin\DegreeController;
use Modules\Recruitment\Http\Controllers\Admin\SearchController;
use Modules\Recruitment\Http\Controllers\Admin\BenefitController;
use Modules\Recruitment\Http\Controllers\Admin\CollegeController;
use Modules\Recruitment\Http\Controllers\Admin\ContactController;
use Modules\Recruitment\Http\Controllers\Admin\JobTypeController;
use Modules\Recruitment\Http\Controllers\Admin\ProfileController;
use Modules\Recruitment\Http\Controllers\Admin\CalendarController;
use Modules\Recruitment\Http\Controllers\Admin\LocationController;
use Modules\Recruitment\Http\Controllers\Admin\ScheduleController;
use Modules\Recruitment\Http\Controllers\Admin\SettingsController;
use Modules\Recruitment\Http\Controllers\Admin\CandidateController;
use Modules\Recruitment\Http\Controllers\Admin\DashboardController;
use Modules\Recruitment\Http\Controllers\Admin\JobOpeningController;
use Modules\Recruitment\Http\Controllers\Admin\PermissionController;
use Modules\Recruitment\Http\Controllers\Admin\UserProfileController;
use Modules\Recruitment\Http\Controllers\Admin\NotificationController;
use Modules\Recruitment\Http\Controllers\Admin\EducationLevelController;
use Modules\Recruitment\Http\Controllers\Admin\JobApplicationController;
use Modules\Recruitment\Http\Controllers\Admin\Quiz\QuizCoursesController;
use Modules\Recruitment\Http\Controllers\Admin\Quiz\QuizQuestionsController;
use Modules\Recruitment\Http\Controllers\Admin\Quiz\QuizAssignmentController;
use Modules\Recruitment\Http\Controllers\Admin\Quiz\ExamMonitoringController;
use Modules\Recruitment\Http\Controllers\Candidate\MCQController;



// Route::get("admin/stream",[MCQController::class,'stream'])->name('admin.stream');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('auth')->group(function () {

        Route::get('/search', [SearchController::class, 'search'])->name('search');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/calendar/events', [DashboardController::class, 'calendarEvents'])->name('calendar.events');
        Route::get('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');
        Route::get('dashboard/refresh', [DashboardController::class, 'refresh'])->name('dashboard.refresh');
        Route::get('dashboard/export/{metric}', [DashboardController::class, 'export'])
            ->name('dashboard.export');
        Route::get('dashboard/trends', [DashboardController::class, 'trends'])
            ->name('dashboard.trends');
        Route::resource('users', UserProfileController::class)
            ->except(['show'])
            ->names('users');


        Route::resource('jobs', JobOpeningController::class);

        Route::get('/jobs/getskills', [JobOpeningController::class, 'getSkills'])->name('skill.list');
        Route::patch('jobs/{job}/toggle-status', [JobOpeningController::class, 'toggleStatus'])
            ->name('jobs.toggleStatus');
        Route::resource('skills', \Modules\Recruitment\Http\Controllers\Admin\SkillController::class)->except(['show']);
        // Route::resource('candidate', CandidateController::class)->except(['show']);
        Route::resource('educationLevels', EducationLevelController::class)->except(['show']);

        Route::resource('benefits', BenefitController::class);
        Route::resource('jobTypes', JobTypeController::class)->except(['show']);
        Route::resource('schedules', ScheduleController::class)->except(['show']);
        Route::resource('degrees', DegreeController::class)->except(['show']);
        Route::resource('clients', ClientController::class);
        Route::post('clients/{client}/toggle-status', [ClientController::class, 'toggleActiveStatus'])->name('clients.toggle-status');
        Route::post('clients/{client}/toggle-featured', [ClientController::class, 'toggleFeaturedStatus'])->name('clients.toggle-featured');
        Route::resource('locations', LocationController::class)->except(['show']);

        Route::post('skills/search', [\Modules\Recruitment\Http\Controllers\Admin\SkillController::class, 'search'])->name('skills.search');
        Route::post('skills/add-multiple', [\Modules\Recruitment\Http\Controllers\Admin\SkillController::class, 'addMultiple']);
        Route::delete('skills/{skillId}/remove', [\Modules\Recruitment\Http\Controllers\Admin\SkillController::class, 'remove']);
        Route::get('job-openings/{jobOpeningId}/skills', [\Modules\Recruitment\Http\Controllers\Admin\SkillController::class, 'getJobOpeningSkills']);

        Route::prefix('candidates')->name('candidates.')->group(function () {
            Route::get('/', [CandidateController::class, 'index'])->name('index');
            Route::get('/create', [CandidateController::class, 'create'])->name('create');
            Route::post('/', [CandidateController::class, 'store'])->name('store');
            Route::get('/{candidate}', [CandidateController::class, 'show'])->name('show');
            Route::get('/{candidate}/edit', [CandidateController::class, 'edit'])->name('edit');
            Route::put('/{candidate}', [CandidateController::class, 'update'])->name('update');
            Route::delete('/{candidate}', [CandidateController::class, 'destroy'])->name('destroy');
            Route::get('/search', [CandidateController::class, 'search'])->name('search');
            Route::post('/filter', [CandidateController::class, 'filter'])->name('filter');
        });


        Route::post('/jobs/generateJobDescription', [JobOpeningController::class, 'generateDescription'])
            ->name('generateDescription');


        Route::resource('job-applications', JobApplicationController::class)->except('show');
        // Route::get('job-applications/{id}/resume', [JobApplicationController::class, 'downloadResume'])
        //     ->name('job-applications.resume');
        Route::put('/admin/job-applications/{id}/status', [JobApplicationController::class, 'updateStatus'])->name('job-applications.updateStatus');





        Route::get('/job-applications/{id}', [JobApplicationController::class, 'show'])->name('job-applications.show');
        Route::put('/job-applications/{id}/status', [JobApplicationController::class, 'updateStatus'])->name('job-applications.status.update');
        Route::get('/job-applications/{id}/download', [JobApplicationController::class, 'download'])->name('job-applications.download');


        // Contacts routes
        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::get('/{id}', [ContactController::class, 'show'])->name('show');
            Route::post('/{id}/toggle-read', [ContactController::class, 'toggleReadStatus'])->name('toggle-read');
            Route::post('/{id}/reply', [ContactController::class, 'reply'])->name('reply');
            Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [ContactController::class, 'bulkDelete'])->name('bulk-delete');
        });


        Route::get('calendar/events', [CalendarController::class, 'getEvents']);

        // Roles and Permissions Routes
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}', [RoleController::class, 'show'])->name('show');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
            Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('permissions');
            Route::put('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('permissions.update');
            Route::get('/{role}/users', [RoleController::class, 'getUsers'])->name('users');
            Route::post('/{role}/users/{user}', [RoleController::class, 'assignUser'])->name('users.assign');
            Route::delete('/{role}/users/{user}', [RoleController::class, 'removeUser'])->name('users.remove');
            Route::get('/available-users', [RoleController::class, 'getAvailableUsers'])->name('available-users');
        });

        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
            Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
            // Route::get('/categories', [PermissionController::class, 'getCategories'])->name('categories');
        });


        // College routes
        Route::get('/colleges', [CollegeController::class, 'index'])->name('colleges.index');
        Route::get('/colleges/{college}', [CollegeController::class, 'show'])->name('colleges.show');
        Route::delete('/colleges/{college}', [CollegeController::class, 'destroy'])->name('colleges.destroy');
        Route::post('/colleges/{college}/toggle-status', [CollegeController::class, 'toggleStatus'])->name('colleges.toggle-status');
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

        // Settings Routes
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

        // Notification Routes
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');

        // Help Route
        Route::get('/help', [HelpController::class, 'index'])->name('help');


        Route::prefix('quiz')->name('quiz.')->group(function () {
            Route::resource('courses', QuizCoursesController::class);
            Route::get('courses/{id}/quizes', [QuizQuestionsController::class, 'index'])->name('quizes.index');
            Route::get('courses/{id}/quizes/create', [QuizQuestionsController::class, 'create'])->name('quizes.create');
            Route::delete('courses/{id}/quizes/delete', [QuizQuestionsController::class, 'destroy'])->name('quizes.destroy');
            Route::post('courses/quizes/store', [QuizQuestionsController::class, 'store'])->name('quizes.store');

            Route::get('courses/quizes/{id}/edit', [QuizQuestionsController::class, 'editQuizBasicInfo'])->name('courses.quizes.basic.info.edit');
            Route::put('courses/quizes/update', [QuizQuestionsController::class, 'updateQuizBasicInfo'])->name('courses.quizes.basic.info.update');


            Route::get('/quiz/{id}', [QuizQuestionsController::class, 'show'])->name('quizes.show');
            Route::put('/quiz/category/{id}/updatestatus', [QuizQuestionsController::class, 'updateCategoriesStatus'])->name('quiz.category.update.active.status');

            Route::get('/quiz/{id}/category/create', [QuizQuestionsController::class, 'createNewCategory'])->name('quiz.category.create');
            Route::post('/quiz/category/store', [QuizQuestionsController::class, 'storeNewCategory'])->name('quiz.category.store');
            Route::get('/quiz/category/{id}/edit', [QuizQuestionsController::class, 'editCategories'])->name('quiz.category.edit');
            Route::put('/quiz/category/update', [QuizQuestionsController::class, 'updateCategories'])->name('quiz.category.update');

            Route::get('/quiz/category/{quizId}/{categoryId}/question/create', [QuizQuestionsController::class, 'createNewQuestion'])->name('quiz.category.question.create');  //not in use
            Route::post('/quiz/category/question/store', [QuizQuestionsController::class, 'storeNewQuestion'])->name('quiz.category.question.store');
            Route::get('/quiz/category/question/{id}/edit', [QuizQuestionsController::class, 'editQuestion'])->name('quiz.category.question.edit');  //not in use
            Route::post('/quiz/category/question/update', [QuizQuestionsController::class, 'updateQuestion'])->name('quiz.category.question.update');
            Route::get('/quiz/result/{quizId}/{status?}', [QuizQuestionsController::class, 'getExamResult'])->name('quizes.show.results');
            Route::get('/quiz/result/exports/{quizId}/{status?}', [QuizQuestionsController::class, 'pdfExport'])->name('quizes.show.results.export');

            Route::get('monitoring', [ExamMonitoringController::class, 'index'])->name('monitoring.index');
            Route::get('monitoring/attempts', [ExamMonitoringController::class, 'getAttempts'])->name('monitoring.attempts');
            Route::get('monitoring/stats', [ExamMonitoringController::class, 'getStats'])->name('monitoring.stats');
        });

        Route::resource('quiz/assigned/quizes', QuizQuestionsController::class);



        // Quiz Assignment Routes
        Route::prefix('quiz/quizes/{quizId}/assignments')->name('quiz.assignments.')->group(function () {
            Route::get('/', [QuizAssignmentController::class, 'index'])->name('index');
            Route::get('/create', [QuizAssignmentController::class, 'create'])->name('create');
            Route::post('/', [QuizAssignmentController::class, 'store'])->name('store');
            Route::get('/{assignmentId}', [QuizAssignmentController::class, 'show'])->name('show');
            Route::get('/{assignmentId}/edit', [QuizAssignmentController::class, 'edit'])->name('edit');
            Route::put('/{assignmentId}', [QuizAssignmentController::class, 'update'])->name('update');
            Route::delete('/{assignmentId}', [QuizAssignmentController::class, 'destroy'])->name('destroy');
        });


        Route::prefix('placement')->name('placement.')->group(function () {
            Route::get('/', [PlacementDriveController::class, 'index'])->name('index');
            Route::get('/create', [PlacementDriveController::class, 'create'])->name('create');
            Route::get('/searchcollege', [PlacementDriveController::class, 'searchCollege'])->name('search.college');
            Route::get('/searchskills', [PlacementDriveController::class, 'searchSkills'])->name('search.skills');
            Route::get('/searchdegree', [PlacementDriveController::class, 'searchDegree'])->name('search.degree');
            Route::post('/store', [PlacementDriveController::class, 'store'])->name('store');
            Route::get('/show/{id?}', [PlacementDriveController::class, 'show'])->name('show');
            Route::get('/edit/{id?}', [PlacementDriveController::class, 'edit'])->name('edit');
            Route::put('/update', [PlacementDriveController::class, 'update'])->name('update');
            Route::delete('/delete/{id?}', [PlacementDriveController::class, 'destroy'])->name('delete');
            Route::put('/{placementId}/updatestatus', [PlacementDriveController::class, 'updateStatus'])->name('updatestatus');


            Route::get('/addcollege/{id?}', [PlacementDriveController::class, 'addCollege'])->name('add.college');
            Route::post('/addcollege/store', [PlacementDriveController::class, 'storeNewCollege'])->name('store.college');

            Route::get('/{placementId}/college/{placementCollegId?}/schedulequiz', [PlacementDriveController::class, 'createQuizSchedule'])->name('schedule.quiz.create');
            Route::post('/schedulequiz', [PlacementDriveController::class, 'storeQuizSchedule'])->name('schedule.quiz.store');
            Route::get('/fetch-quizzes-by-course/{courseId}', [PlacementDriveController::class, 'getQuizzesByCourse'])->name('fetch.quizzes');

            Route::get('/{placement}/quiz-schedules', [PlacementDriveController::class, 'showScheduleQuiz'])->name('quiz.schedule.show');
            Route::get('/quiz-schedules/{id?}', [PlacementDriveController::class, 'editQuizSchedule'])->name('quiz.schedule.edit');
            Route::put('/quiz-schedules/{id?}', [PlacementDriveController::class, 'updateQuizSchedule'])->name('quiz.schedule.update');


            Route::get('/{placementId}/college/{placementCollegId?}/details', [PlacementDriveController::class, 'showScheduleStudent'])->name('college.quiz.studuent');
            Route::get('/quiz/result/exports/{placementId}/{placementCollegeId}', [PlacementDriveController::class, 'pdfExportAllByPlacement'])->name('drive.quizes.show.results.export');
        });
    });
});
