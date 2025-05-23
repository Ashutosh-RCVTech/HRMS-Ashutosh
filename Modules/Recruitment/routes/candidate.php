<?php

use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Http\Controllers\Candidate\FAQController;
use Modules\Recruitment\Http\Controllers\Candidate\MCQController;
use Modules\Recruitment\Http\Controllers\Candidate\ProfileController;
use Modules\Recruitment\Http\Controllers\Auth\CandidateAuthController;
use Modules\Recruitment\Http\Controllers\Candidate\DashboardController;
use Modules\Recruitment\Http\Controllers\Candidate\JobOpeningController;
use Modules\Recruitment\Http\Controllers\Candidate\GithubLoginController;
use Modules\Recruitment\Http\Controllers\Candidate\GoogleLoginController;
use Modules\Recruitment\Http\Controllers\Candidate\JobApplicationController;
use Modules\Recruitment\Http\Controllers\Candidate\QuizAssignmentController;
use Modules\Recruitment\Http\Controllers\Candidate\AuthMcqCandidateController;
use Modules\Recruitment\Http\Controllers\Candidate\CandidateProfileController;
use Modules\Recruitment\app\Http\Controllers\Candidate\PlacementDriveController;
use Modules\Recruitment\Http\Controllers\Candidate\ActivityMcqCandidateController;

Route::prefix('candidate')->name('candidate.')->group(function () {
    // Guest Routes
    Route::middleware('candidate-guest')->group(function () {
        Route::get('/login', [CandidateAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [CandidateAuthController::class, 'login']);
        Route::get('/register', [CandidateAuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [CandidateAuthController::class, 'register']);

        // Password Reset Routes
        Route::get('/password/reset', [CandidateAuthController::class, 'showPasswordRequestForm'])->name('password.request');
        Route::post('/password/email', [CandidateAuthController::class, 'sendPasswordResetLink'])->name('password.email');
        Route::get('/password/reset/{token}', [CandidateAuthController::class, 'showPasswordResetForm'])->name('password.reset');
        Route::post('/password/update', [CandidateAuthController::class, 'resetPassword'])->name('password.update');

        // Email Verification Routes for guests


        Route::prefix('jobs')->name('jobs.')->group(function () {
            Route::get('/', [JobOpeningController::class, 'index'])->name('index');
            Route::get('search-titles', [JobOpeningController::class, 'searchTitles'])
                ->name('search-titles');
            Route::get('{job}/details', [JobOpeningController::class, 'showDetails'])
                ->name('details');
        });
    });

    // Email Verification Routes for authenticated users
    // Route::middleware('checkCandidate')->group(function () {
    //     Route::get('/email/verify/{id}/{hash}', [CandidateAuthController::class, 'verifyEmail'])
    //         ->middleware(['signed'])
    //         ->name('candidate.verification.verify');
    //     Route::get('/email/verify', [CandidateAuthController::class, 'showVerificationNotice'])
    //         ->name('verification.notice');
    //     Route::post('/email/verification-notification', [CandidateAuthController::class, 'resendVerificationEmail'])
    //         ->middleware(['throttle:6,1'])
    //         ->name('verification.send');

    //     // need to verify this route
    //     Route::get('/searchCollege', [CandidateProfileController::class, 'searchCollege'])->name('profile.search.college');
    // });

    // Routes that don't require authentication
    Route::get('/email/verify/{id}/{hash}', [CandidateAuthController::class, 'verifyEmail'])
        // ->middleware(['signed'])
        ->name('verification.verify');

    Route::get('/email/verify', [CandidateAuthController::class, 'showVerificationNotice'])
        ->name('verification.notice');

    // Routes that require authentication
    Route::middleware('checkCandidate')->group(function () {
        Route::post('/email/verification-notification', [CandidateAuthController::class, 'resendVerificationEmail'])
            ->middleware(['throttle:6,1'])
            ->name('verification.send');

        Route::get('/searchCollege', [CandidateProfileController::class, 'searchCollege'])
            ->name('profile.search.college');
    });

    // Protected Routes for Authenticated Candidates
    Route::post('logout', [CandidateAuthController::class, 'logout'])->middleware('checkCandidate')->name('logout');

    // Routes that require both authentication and email verification
    Route::middleware(['checkCandidate', 'checkProfileCompletion', 'verified:candidate'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        // Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/faq', [FAQController::class, 'index'])->name('faq');

        // Job Routes
        Route::prefix('jobs')->name('jobs.')->group(function () {
            Route::post('{id}/apply', [JobOpeningController::class, 'apply'])->name('apply');
            Route::get('show/{id}', [JobOpeningController::class, 'show'])->name('show');
        });

        // MCQ Routes
        Route::prefix('mcq')->name('mcq.')->group(function () {
            Route::get('/', [MCQController::class, 'index'])->name('index');
            Route::get('{id}/start', [MCQController::class, 'start'])->name('start');
            // Route::post('{id}/submit', [MCQController::class, 'submit'])->name('submit');
        });

        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [JobApplicationController::class, 'index'])->name('index');
            Route::get('{id}', [JobApplicationController::class, 'show'])->name('show');
            Route::post('{id}/withdraw', [JobApplicationController::class, 'withdraw'])->name('withdraw');
        });

        // Candidate Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [CandidateProfileController::class, 'edit'])->name('index');
            Route::post('basic', [CandidateProfileController::class, 'updateBasicDetails'])->name('update-basic-details');
            Route::put('education', [CandidateProfileController::class, 'updateEducation'])->name('update-education');
            Route::put('employment', [CandidateProfileController::class, 'updateEmployment'])->name('update-employment');
            Route::put('career', [CandidateProfileController::class, 'updateCareerProfile'])->name('update-career-profile');
        });

        // Placement Drive Routes
        Route::get('/placement', [PlacementDriveController::class, 'index'])->name('placement.index');
        Route::get('/placement/{id}/{collegeId}', [PlacementDriveController::class, 'show'])->name('placement.show');
        Route::get('/placement/mcq/test/{placementId}/{collegeId}/{quizId}', [PlacementDriveController::class, 'startTest'])->name('placement.start-test');
    });

    // Quiz Assignment Routes
    Route::prefix('quiz')->name('quiz.')->middleware(['checkCandidate', 'verified:candidate'])->group(function () {
        Route::get('/assignments', [QuizAssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/{assignmentId}', [QuizAssignmentController::class, 'show'])->name('assignments.show');
        Route::get('/assignments/{assignmentId}/start', [QuizAssignmentController::class, 'startQuiz'])->name('assignments.start');
    });

    Route::prefix('mcq')->name('mcq.')->group(function () {
        Route::get('signin/placement/test/{placementId}/{collegeId}/{quizId}', [MCQController::class, 'landing'])->name('signin');
        Route::post('login', [AuthMcqCandidateController::class, 'login'])->name('login');
        Route::post('logout', [AuthMcqCandidateController::class, 'logout'])->name('logout');
        Route::get('quiz/{placementId}/{collegeId}/{quizId}', [MCQController::class, 'index'])->name('quiz');
        Route::post('submit', [MCQController::class, 'submitExam'])->name('submit');
        Route::post('before-time-submit', [MCQController::class, 'beforeTimeSubmit'])->name('before-time-submit');

        Route::post('log-activity', [ActivityMcqCandidateController::class, 'logActivity'])->name('log.activity');
        Route::get('exam-ended', [McqController::class, 'showEndedExam'])
            ->name('exam.ended');
        Route::get('thanks', [MCQController::class, 'thanksCandidate'])->name('thanks');

        Route::get('/exam-mcq-user-result/{quizId}/{mcqtestcandidateId}', [McqController::class, 'getExamResult'])->name('showResult');
        Route::get('/activities/{candidate}', [ActivityMcqCandidateController::class, 'candidateActivities'])->name('activities');
    });
});


Route::get('/email/verification/status', [CandidateAuthController::class, 'verificationStatus'])
    ->middleware('auth:candidate')
    ->name('candidate.verification.status');
Route::get('/api/jobs/suggestions', [JobOpeningController::class, 'suggestions']);

// Google login routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('google', [GoogleLoginController::class, 'redirectToGoogle'])
        ->name('google.login');

    Route::get('google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])
        ->name('google.callback');

    Route::get('github', [GithubLoginController::class, 'redirectToGithub'])
        ->name('github.login');

    Route::get('github/callback', [GithubLoginController::class, 'handleGithubCallback'])
        ->name('github.callback');
});
