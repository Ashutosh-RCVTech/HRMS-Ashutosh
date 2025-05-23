<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Providers\RouteServiceProvider;

class GithubLoginController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }


    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->stateless()->user();
        // If the user doesn't exist create, else update the existing one
        $user = CandidateUser::updateOrCreate([
            'email' => $githubUser->getEmail(),
        ], [
            'provider_id' => $githubUser->getId(),
            'name' => $githubUser->getName() ?? $githubUser->getNickname(),
            'token' => $githubUser->token,
            'password' => Hash::make(rand(100000, 999999))
        ]);
        // Ensure 'candidate' guard is used
        Auth::guard('candidate')->login($user);

        return redirect(RouteServiceProvider::CANDIDATE_HOME());
        // return redirect('/candidate/dashboard');
    }
}
