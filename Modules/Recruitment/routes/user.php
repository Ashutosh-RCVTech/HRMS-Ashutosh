<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Http\Controllers\Admin\CandidateController;
use Modules\Recruitment\Http\Controllers\Admin\JobOpeningController;




// Route::domain(env('APP_USER_DOMAIN'))
//     ->prefix(env('APP_USER_PREFIX'))
//     ->as('user.')->namespace('User')->group(function () {
//         Route::as('user.')->group(function () {

//             Route::middleware('auth:user')->group(function () {
//                 Route::resource('jobs', JobOpeningController::class)->except(['show']);
//                 Route::get('/jobs/getskills', [JobOpeningController::class, 'getSkills'])->name('skill.list');
//                 Route::resource('candidate', CandidateController::class)->except(['show']);
//             });
//         });
//     });
