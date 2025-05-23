<?php

namespace Modules\Recruitment\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\McqTestCandidate;
use Modules\Recruitment\Http\Requests\Candidate\RegisterRequest;

class CandidateAuthController extends Controller
{
    /**
     * Display the login form for candidates.
     */
    public function showLoginForm()
    {
        // If already logged in as candidate, redirect to dashboard
        if (Auth::guard('candidate')->check()) {
            return redirect()->route('candidate.dashboard');
        }
        return view('recruitment::candidate.auth.login');
    }

    /**
     * Logout the candidate and invalidate the session.
     */
    public function logout(Request $request)
    {
        // Log out the candidate using the 'candidate' guard
        Auth::guard('candidate')->logout();

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('candidate.login');
    }

    /**
     * Handle the candidate registration.
     */
    public function register(RegisterRequest $request)
    {
        // Create a new candidate record with validated data
        $candidate = CandidateUser::create([
            'name' => strip_tags($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Send email verification notification
        $this->sendEmailVerificationNotification($candidate);

        // Log the candidate in after registration
        Auth::guard('candidate')->login($candidate);

        //Check if getting verfied and login is successful

        // Redirect with notice about email verification
        return redirect()->route('candidate.verification.notice');
    }

    /**
     * Send email verification link to the candidate
     */
    private function sendEmailVerificationNotification($candidate)
    {
        // Generate signed verification URL
        $verificationUrl = URL::temporarySignedRoute(
            'candidate.verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $candidate->id, 'hash' => sha1($candidate->email)]
        );
        // Send email with verification link
        Mail::send('recruitment::emails.candidate_verification', ['url' => $verificationUrl], function ($message) use ($candidate) {
            $message->to($candidate->email)->subject('Verify Your Email Address');
        });
    }

    /**
     * Show the candidate registration form.
     */
    public function showRegistrationForm()
    {
        return view('recruitment::candidate.auth.register');
    }

    /**
     * Show the email verification notice.
     */
    // public function showVerificationNotice()
    // {
    //     return view('recruitment::candidate.auth.verify-email');
    // }

    /**
     * Show the email verification notice.
     */
    public function showVerificationNotice()
    {
        // If the user is verified, redirect to dashboard
        if (Auth::guard('candidate')->check() && Auth::guard('candidate')->user()->hasVerifiedEmail()) {
            return redirect()->route('candidate.dashboard');
        }

        return view('recruitment::candidate.auth.verify-email');
    }

    /**
     * Verify the candidate's email.
     */
    // public function verifyEmail(Request $request)
    // {
    //     // dd($request->candidate->id);
    //     $candidate = CandidateUser::findOrFail($request->candidate->id);




    //     // Check if URL is valid
    //     if (!hash_equals(sha1($candidate->email), $request->hash)) {
    //         return redirect()->route('candidate.verification.notice')
    //             ->with('error', 'Invalid verification link.');
    //     }

    //     // Check if URL is expired
    //     if (!$request->hasValidSignature()) {
    //         return redirect()->route('candidate.verification.notice')
    //             ->with('error', 'Verification link has expired.');
    //     }


    //     // Check if email is already verified
    //     if ($candidate->hasVerifiedEmail()) {
    //         return redirect()->route('candidate.dashboard')
    //             ->with('info', 'Your email is already verified.');
    //     }


    //     try {
    //         // Mark email as verified

    //         $candidate->markEmailAsVerified();

    //         return redirect()->route('candidate.dashboard')
    //             ->with('success', 'Your email has been verified successfully!');
    //     } catch (\Exception $e) {
    //         Log::error('Email verification failed: ' . $e->getMessage());
    //         return redirect()->route('candidate.verification.notice')
    //             ->with('error', 'Email verification failed. Please try again or contact support.');
    //     }
    // }


    /**
     * Verify the candidate's email.
     */
    // public function verifyEmail(Request $request)
    // {
    //     // Add logging to debug
    //     \Log::debug('Verification attempt', [
    //         'id' => $request->id,
    //         'hash' => $request->hash,
    //         'user' => $request->user()?->id,
    //         'valid_signature' => $request->hasValidSignature()
    //     ]);


    //     $candidate = CandidateUser::findOrFail($request->candidate->id);

    //     // Check if URL is valid
    //     if (!hash_equals(sha1($candidate->email), $request->hash)) {
    //         return redirect()->route('candidate.verification.notice')
    //             ->with('error', 'Invalid verification link.');
    //     }

    //     // Check if URL is expired
    //     if (!$request->hasValidSignature()) {
    //         return redirect()->route('candidate.verification.notice')
    //             ->with('error', 'Verification link has expired.');
    //     }

    //     // Check if email is already verified
    //     if ($candidate->hasVerifiedEmail()) {
    //         return redirect()->route('candidate.dashboard')
    //             ->with('info', 'Your email is already verified.');
    //     }

    //     try {
    //         // Mark email as verified
    //         $candidate->markEmailAsVerified();

    //         // For AJAX requests, return a JSON response
    //         if ($request->expectsJson()) {
    //             return response()->json(['success' => true, 'message' => 'Email verified successfully']);
    //         }

    //         return redirect()->route('candidate.dashboard')
    //             ->with('success', 'Your email has been verified successfully!');
    //     } catch (\Exception $e) {
    //         Log::error('Email verification failed: ' . $e->getMessage());
    //         return redirect()->route('candidate.verification.notice')
    //             ->with('error', 'Email verification failed. Please try again or contact support.');
    //     }
    // }

    public function verifyEmail(Request $request)
    {

        $candidate = CandidateUser::findOrFail($request->id);

        // Check if URL is valid
        if (!hash_equals(sha1($candidate->email), (string) $request->hash)) {
            return redirect()->route('candidate.verification.notice')
                ->with('error', 'Invalid verification link.');
        }

        // Check if URL is expired
        if (!$request->hasValidSignature()) {
            return redirect()->route('candidate.verification.notice')
                ->with('error', 'Verification link has expired.');
        }

        // Check if email is already verified
        if ($candidate->hasVerifiedEmail()) {
            // Log in the user if they're not already
            if (!Auth::guard('candidate')->check()) {
                Auth::guard('candidate')->login($candidate);
            }
            return redirect()->route('candidate.dashboard')
                ->with('info', 'Your email is already verified.');
        }

        try {
            // Mark email as verified
            $candidate->markEmailAsVerified();
            
            // Log in the user
            Auth::guard('candidate')->login($candidate);

            return redirect()->route('candidate.dashboard')
                ->with('success', 'Your email has been verified successfully!');
        } catch (\Exception $e) {
            Log::error('Email verification failed: ' . $e->getMessage());
            return redirect()->route('candidate.verification.notice')
                ->with('error', 'Email verification failed. Please try again or contact support.');
        }
    }
    /**
     * Resend the email verification notification.
     */
    public function resendVerificationEmail(Request $request)
    {
        $candidate = Auth::guard('candidate')->user();

        if ($candidate->hasVerifiedEmail()) {
            return redirect()->route('candidate.dashboard')
                ->with('info', 'Your email is already verified.');
        }

        $this->sendEmailVerificationNotification($candidate);

        return back()->with('status', 'Verification link has been resent!');
    }

    public function showPasswordRequestForm()
    {
        return view('recruitment::candidate.auth.passwords.email');
    }

    /**
     * Send password reset link
     */
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if the email exists in candidate_users table
        $candidate = CandidateUser::where('email', $request->email)->first();

        if (!$candidate) {
            return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
        }

        // Generate a unique token
        $token = Str::random(60);

        // Store the token in the password reset tokens table
        DB::table('candidate_password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Send password reset email
        $resetUrl = route('candidate.password.reset', ['token' => $token, 'email' => $request->email]);

        Mail::send('recruitment::emails.candidate_password_reset', ['resetUrl' => $resetUrl], function ($message) use ($request) {
            $message->to($request->email)->subject('Reset Your Password');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    /**
     * Show password reset form
     */
    public function showPasswordResetForm(Request $request, $token)
    {
        return view('recruitment::candidate.auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ]
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
            'password.min' => 'Password must be at least 6 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Verify the token
        $passwordReset = DB::table('candidate_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'This password reset token is invalid.']);
        }

        // Update the password
        $candidate = CandidateUser::where('email', $request->email)->first();
        $candidate->password = Hash::make($request->password);
        $candidate->save();

        // Remove the password reset token
        DB::table('candidate_password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Log the user in
        Auth::guard('candidate')->login($candidate);

        return redirect()->route('candidate.dashboard')
            ->with('status', 'Your password has been reset successfully!');
    }

    /**
     * Handle "Remember Me" login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Add remember me functionality
        $remember = $request->has('remember_me');

        if (Auth::guard('candidate')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if email is verified
            $candidate = Auth::guard('candidate')->user();
            if (!$candidate->hasVerifiedEmail()) {
                return redirect()->route('candidate.verification.notice');
            }

            return redirect()->intended(route('candidate.dashboard'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }


    /**
     * Check email verification status for AJAX calls
     */
    public function verificationStatus(Request $request)
    {
        $user = Auth::guard('candidate')->user();
        return response()->json([
            'verified' => $user && $user->hasVerifiedEmail(),
        ]);
    }
}
