<?php

use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Http\Controllers\RecruitmentController;
use Modules\Recruitment\Http\Controllers\NotificationController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('recruitment', RecruitmentController::class)->names('recruitment');

    // Notification API routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/unread', [NotificationController::class, 'unread'])->name('unread');
        Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-multiple-read', [NotificationController::class, 'markMultipleAsRead'])->name('mark-multiple-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/delete-multiple', [NotificationController::class, 'destroyMultiple'])->name('destroy-multiple');
        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clear-all');
    });
});
