<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\CollegeCandidate;
use Modules\Recruitment\Models\CollegeCandidatePlacement;
use Modules\Recruitment\Models\McqTestCandidate;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthMcqCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */




    public function login(Request $request)
    {

     
        $request->validate([
            'email' => 'required|email',
            'quiz_id' => 'required',
            'password' => 'required',
        ]);

        $key = 'login-attempts:' . Str::lower($request->email);

        // Apply rate limiting: 5 attempts per minute
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ])->withInput($request->only('email'));
        }

        try {
            $placementId = decrypt($request->placement_id);
            $collegeId = decrypt($request->college_id);
            $quizId = decrypt($request->quiz_id);

//             dd($placementId);
// dd(2,encrypt(2),   decrypt(encrypt(2)));


            $candidate = CandidateUser::where('email', $request->email)->first();

            if (!$candidate) {
                RateLimiter::hit($key);
                return back()->withErrors(['email' => 'Candidate not found.'])->withInput();
            }

            $candidateCollege = CollegeCandidate::where('candidate_id', $candidate->id)
                ->where('college_id', $collegeId)
                ->first();

            if (!$candidateCollege) {
                RateLimiter::hit($key);
                return back()->withErrors([
                    'college_id' => "You do not belong to this college.",
                ])->withInput($request->only('college_id'));
            }

            $candidateCollegePlacement = CollegeCandidatePlacement::where('college_candidate_id', $candidateCollege->id)
                ->where('placement_id', $placementId)
                ->first();

            if (!$candidateCollegePlacement) {
                RateLimiter::hit($key);
                return back()->withErrors([
                    'placement_id' => "No placement drive found for you. Please contact the organization.",
                ])->withInput($request->only('placement_id'));
            }


            // dd($quizId);
            // Optional: Check if already exists to prevent duplicate entries
            $mcqCandidate = McqTestCandidate::firstOrCreate([
                'candidate_id' => $candidate->id,
                'college_id' => $collegeId,
                'quiz_id' => $quizId,
                'placement_id' => $placementId,
                'email' => $candidate->email,
                'password' => $candidate->password,
            ]);

            // Prepare credentials
            $credentials = [
                'candidate_id' => $candidate->id,
                'college_id' => $collegeId,
                'quiz_id' => $quizId,
                'placement_id' => $placementId,
                'email' => $candidate->email,
                'password' => $request->password,
            ];

            // Attempt to login using custom guard (ensure proper guard is set up)
            if (Auth::guard('mcq_test_candidate')->attempt($credentials)) {
                RateLimiter::clear($key);
                return redirect()->intended(route('candidate.mcq.quiz', [encrypt($placementId),encrypt($collegeId), encrypt($quizId)]));
            }

            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->withInput($request->only('email'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            RateLimiter::hit($key);
            return back()->withErrors([
                'quiz_id' => __('Invalid quiz identifier'),
            ]);
        }

    }

    public function logout(Request $request)
    {
        $authUser = auth('mcq_test_candidate')->user();
        $placementId=encrypt(auth('mcq_test_candidate')->user()->placement_id);
        $collegeId=encrypt(auth('mcq_test_candidate')->user()->college_id);


        activity('candidateLog out')
            ->causedBy($authUser)
            ->withProperties([
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ])
            ->log("candidateLogged Out");

        Log::info('candidatelogged out', [
            'user_id' => $authUser->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        auth('mcq_test_candidate')->logout();
        // $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Retrieve mcqId from the request or use a default if needed.
        $mcqId =encrypt($request->input('quizId'));

        return redirect()->route('candidate.mcq.signin', ['placementId'=>$placementId,'collegeId'=>$collegeId,'quizId' => $mcqId]);
    }




    public function index()
    {
        return view('recruitment::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruitment::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('recruitment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('recruitment::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
