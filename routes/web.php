<?php

use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Http\Controllers\ContactController;
use Modules\Recruitment\Http\Controllers\LandingController;
use Modules\Recruitment\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CollegeController;

Route::get('/', [LandingController::class, 'index'])->name('landing');


Route::get("/organization", function () {
    return view("coming-soon");
})->name('organization');


// Static Pages
Route::get('/about', function () {
    return view('landing.about');
})->name('about');

Route::get('/contact', function () {
    return view('landing.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('landing.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('landing.terms');
})->name('terms');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


require __DIR__ . '/auth.php';
