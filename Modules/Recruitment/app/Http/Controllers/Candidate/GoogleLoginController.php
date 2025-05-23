<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Providers\RouteServiceProvider;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = CandidateUser::where('email', $googleUser->email)->first();
        if (!$user) {
            $user = CandidateUser::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make(rand(100000, 999999))
            ]);
        }

        Auth::guard('candidate')->login($user); // 'candidate' guard is used

        return redirect(RouteServiceProvider::CANDIDATE_HOME());
        // return redirect('/candidate/dashboard');
    }
}
