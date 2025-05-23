<?php

use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Http\Controllers\Admin\CollegeController;
use Modules\Recruitment\Http\Controllers\PlacementDriveController;
use Modules\Recruitment\Http\Controllers\NotificationController;

// Admin routes
// Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {});

Route::middleware(['web', 'auth'])->group(function () {
    // ... existing routes ...

    // Notification routes
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
