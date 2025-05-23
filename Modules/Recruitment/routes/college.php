<?php

use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Http\Controllers\College\CollegeController;
use Modules\Recruitment\Http\Controllers\College\ProfileController;
use Modules\Recruitment\Http\Controllers\College\PlacementDriveController;
use Modules\Recruitment\Http\Controllers\College\CollegeDashboardController;

/*
|--------------------------------------------------------------------------
| College Routes
|--------------------------------------------------------------------------
*/

// College Authentication Routes
Route::prefix('college')->name('college.')->group(function () {
    // Guest routes
    Route::middleware('guest:college')->group(function () {
        Route::get('login', [CollegeController::class, 'showLoginForm'])->name('login');
        Route::post('login', [CollegeController::class, 'login']);
        Route::get('register', [CollegeController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [CollegeController::class, 'register']);

        // Password Reset Routes
        Route::get('forgot-password', [CollegeController::class, 'showForgotPasswordForm'])
            ->name('password.request');
        Route::post('forgot-password', [CollegeController::class, 'sendResetLinkEmail'])
            ->name('password.email');
        Route::get('reset-password/{token}', [CollegeController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('reset-password', [CollegeController::class, 'reset'])
            ->name('password.update');
    });

    // Email verification status check
    Route::get('email/verification/status', [CollegeController::class, 'verificationStatus'])
        ->middleware('auth:college')
        ->name('verification.status');

    // Authenticated routes
    Route::middleware(['college.auth'])->group(function () {
        Route::post('logout', [CollegeController::class, 'logout'])->name('logout');

        Route::get('candidate-import/{placementid}', [CollegeController::class, 'showImportForm'])->name('candidate.import');
        Route::post('import-submit', [CollegeController::class, 'submitImport'])->name('import.submit');
        Route::get('placment-search-list', [CollegeController::class, 'searchPlacement'])->name('placement.search');
        Route::get('college-placement-list/{collegeId}', [CollegeController::class, 'collegePlacementList'])->name('placement.list');
        Route::get('placement-detail', [CollegeController::class, 'collegePlacementDetails'])->name('placement.detail');

        Route::get('candidate/placement/detail/{placementid}', [CollegeController::class, 'showPlacementDetail'])->name('candidate.placement.detail');

        Route::get('candidate', [CollegeController::class, 'collegeCandidates'])->name('candidate');
        Route::put('/placement/{placement}/accept', [CollegeController::class, 'acceptPlacement'])
            ->name('placement.accept');

        Route::put('/placement/{placement}/reject', [CollegeController::class, 'rejectPlacement'])
            ->name('placement.reject');

        Route::get('/placement/{placement}/assigned', [CollegeController::class, 'assignedCandidates'])
            ->name('candidate.placement.assigned')->middleware('check-college-placement-acceptance');

        Route::post('assiged-placement-candiadte', [CollegeController::class, 'assignedPlacementCandidate'])->name('assigned.placement');
        // Email verification routes (accessible without verification)

        Route::post('candidate/placement/insert/assign', [CollegeController::class, 'assignInsertPlacementCandidates'])
            ->name('candedate.placement.insert.assignd');

        Route::get('email/verify', [CollegeController::class, 'showVerificationNotice'])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [CollegeController::class, 'verifyEmail'])
            ->middleware(['signed'])
            ->name('verification.verify');
        Route::post('email/resend', [CollegeController::class, 'resendVerificationEmail'])->name('verification.resend');

        // Protected routes (require both auth and verification)

        Route::get('dashboard', [CollegeDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [CollegeDashboardController::class, 'getPlacementStats'])->name('dashboard.stats');
        Route::post('/placement/{placementId}/acceptance', [CollegeDashboardController::class, 'updatePlacementAcceptance']);


        // Profile routes
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/logo', [ProfileController::class, 'updateLogo'])->name('profile.update.logo');
        Route::get('profile/change-password', [CollegeController::class, 'showChangePasswordForm'])->name('profile.change-password');
        Route::put('profile/change-password', [CollegeController::class, 'changePassword'])->name('profile.update.password');

        // Placement Drive routes
        Route::resource('drives', PlacementDriveController::class);
        Route::put('drives/{drive}/complete', [PlacementDriveController::class, 'complete'])->name('drives.complete');
        Route::put('drives/{drive}/cancel', [PlacementDriveController::class, 'cancel'])->name('drives.cancel');
        Route::put('drives/{drive}/reschedule', [PlacementDriveController::class, 'reschedule'])->name('drives.reschedule');
        Route::put('drives/{drive}/venue', [PlacementDriveController::class, 'updateVenue'])->name('drives.update.venue');
        Route::put('drives/{drive}/max-students', [PlacementDriveController::class, 'updateMaxStudents'])->name('drives.update.max-students');
        Route::put('drives/{drive}/eligibility', [PlacementDriveController::class, 'updateEligibilityCriteria'])->name('drives.update.eligibility');
        Route::put('drives/{drive}/documents', [PlacementDriveController::class, 'updateRequiredDocuments'])->name('drives.update.documents');
    });

    Route::get('/verification-status', [CollegeController::class, 'verificationStatus'])->name('verification.status');
});
