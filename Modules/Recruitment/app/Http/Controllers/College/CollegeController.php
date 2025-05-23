<?php

namespace Modules\Recruitment\Http\Controllers\College;

use Google\Service\Dfareporting\Placement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Recruitment\Models\College;
use Modules\Recruitment\Models\Institution;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Modules\Recruitment\Services\CollegeService;
use Modules\Recruitment\Http\Requests\College\LoginRequest;
use Modules\Recruitment\Http\Requests\College\RegisterRequest;
use Modules\Recruitment\Http\Requests\College\UpdateProfileRequest;
use App\Jobs\ImportCandidate;
use App\Jobs\PlacementAssigned;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Modules\Recruitment\Models\Placement\PlacementColleges;
use Illuminate\Support\Facades\Validator;
use Modules\Recruitment\Models\CollegeCandidate;
use Modules\Recruitment\Models\CollegeCandidatePlacement;
use Modules\Recruitment\Models\Placement\Placements;
use Carbon\Carbon;


class CollegeController extends Controller
{
    protected $collegeService;

    public function __construct(CollegeService $collegeService)
    {
        $this->collegeService = $collegeService;
    }

    public function showLoginForm()
    {
        return view('recruitment::college.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::guard('college')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $college = Auth::guard('college')->user();

            if ($remember && !$college->getRememberToken()) {
                $college->setRememberToken(Str::random(60));
                $college->save();
            }

            return redirect()->intended(route('college.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('recruitment::college.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $college = $this->collegeService->create($request->validated());

        $institution = new Institution();
        $institution->name = $request->name;

        $institution->save();
        Auth::guard('college')->login($college);


        // Send verification email
        $college->sendEmailVerificationNotification();

        return redirect()->route('college.verification.notice')
            ->with('status', 'verification-link-sent');
    }

    public function logout(Request $request)
    {
        Auth::guard('college')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('college.login');
    }

    public function showVerificationNotice()
    {
        return view('recruitment::college.auth.verify-email');
    }

    /**
     * Verify the college's email address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(Request $request)
    {
        $college = College::find($request->route('id'));

        if (!$college) {
            return redirect()->route('college.login')
                ->with('error', 'Invalid verification link.');
        }

        if ($college->email_verified_at) {
            return redirect()->route('college.dashboard')
                ->with('info', 'Email already verified.');
        }

        $college->email_verified_at = now();
        $college->is_verified = true;
        $college->save();

        return redirect()->route('college.dashboard')
            ->with('success', 'Email verified successfully!');
    }

    public function resendVerificationEmail(Request $request)
    {
        // Use Auth::guard('college')->user() 
        $user = Auth::guard('college')->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('college.dashboard');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    // public function showDashboard()
    // {
    //     $college = Auth::guard('college')->user();
    //     $activeDrives = $college->placementDrives()->where('status', 'active')->get();
    //     $upcomingDrives = $college->placementDrives()->where('status', 'active')
    //         ->where('date', '>', now())->get();
    //     $completedDrives = $college->placementDrives()->where('status', 'completed')->get();


    //     return view('recruitment::college.dashboard', compact('college', 'activeDrives', 'upcomingDrives', 'completedDrives'));
    // }

    public function showProfile()
    {
        $college = Auth::guard('college')->user();
        return view('recruitment::college.profile.show', compact('college'));
    }

    public function editProfile()
    {
        $college = Auth::guard('college')->user();
        return view('recruitment::college.profile.edit', compact('college'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $college = Auth::guard('college')->user();

        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // Detailed debug information
            Log::info('File upload attempt:', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'guessed_extension' => $file->guessExtension(),
                'client_extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'error' => $file->getError(),
                'is_valid' => $file->isValid(),
                'validation_rules' => $request->rules()['logo']
            ]);

            try {
                $this->collegeService->updateLogo($college->id, $file);
            } catch (\Exception $e) {
                Log::error('Logo upload failed:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['logo' => 'Failed to upload logo: ' . $e->getMessage()]);
            }
        }

        // Remove logo from data if not being updated
        unset($data['logo']);

        $this->collegeService->update($college->id, $data);

        return redirect()->route('college.profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    public function showChangePasswordForm()
    {
        return view('recruitment::college.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $college = Auth::guard('college')->user();

        if (!Hash::check($request->current_password, $college->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $this->collegeService->update($college->id, [
            'password' => $request->password
        ]);

        return redirect()->route('college.profile.show')
            ->with('success', 'Password changed successfully!');
    }

    /**
     * Show the form to request a password reset link.
     */
    public function showForgotPasswordForm()
    {
        return view('recruitment::college.auth.forgot-password');
    }

    /**
     * Send a password reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:colleges,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view.
     */
    public function showResetForm(Request $request)
    {
        return view('recruitment::college.auth.reset-password', ['token' => $request->token]);
    }

    /**
     * Reset the user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:colleges,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('college.login')->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => [__($status)]]);
    }






    public function acceptPlacement($placementId)
    {
        try {
            $collegeId = Auth::guard('college')->id();

            $placementCollege = PlacementColleges::where([
                'college_id' => $collegeId,
                'placement_id' => $placementId
            ])->firstOrFail();

            $placementCollege->update(['college_acceptance' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error("Acceptance error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500); // Return proper HTTP error code
        }
    }




    public function rejectPlacement($placementId)
    {
        try {
            $collegeId = Auth::guard('college')->id();

            if (!$collegeId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required'
                ], 401);
            }

            $placementCollege = PlacementColleges::where([
                'college_id' => $collegeId,
                'placement_id' => $placementId
            ])->firstOrFail();

            $placementCollege->update(['college_acceptance' => 2]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated to rejected'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Placement not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error("Rejection error: {$e->getMessage()}");
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function showImportForm(Request $request, $placement = null)
    {
        $collegeId = Auth::guard('college')->user()->id;
        $placementId = $placement;
        $placements = Placements::find($placementId);


        if (!$collegeId) {
            return redirect()->route('login')->with('error', 'No college assigned to your account.');
        }


        return view('recruitment::college.bulk-import.candidate', compact('placements', 'placementId'));
    }


    public function searchPlacement(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = PlacementColleges::query()
            ->join('placement', 'placement.id', '=', 'placement_college.id')
            // ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('placement.name', 'like', "%{$search}%");
            });

        $quizzes = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $quizzes->items(),
            'next_page_url' => $quizzes->nextPageUrl(),
            'total' => $quizzes->total()
        ]);
    }


    public function submitImport(Request $request)
    {


        // Validate that a file has been uploaded and a quiz_id is provided
        $collegeId = Auth::guard('college')->user()->id;
        $placementId = $request->placement_id;
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'placement_id' => 'required',
        ]);


        $file = $request->file('file');

        // Load the spreadsheet using IOFactory and convert the active sheet to an array
        $spreadsheet = IOFactory::load($file->getPathName());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();


        $errors = [];
        $validatedRows = [];

        // Assuming the first row (index 0) contains headers, start processing from row index 1
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }
            $rowNumber = $index + 1; // To match Excel's row number

            // Check for a blank row where both name and email are empty (adjust indexes as necessary)
            if (empty($row[0]) && empty($row[1])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'error' => 'Name and Email are both blank'
                ];
                continue;
            }

            // Validate row data assuming:
            // - Column 0 is 'name'
            // - Column 1 is 'email'
            $validator = Validator::make(
                [
                    'name' => $row[0],
                    'email' => $row[1],
                    'placementId' => $placementId
                ],
                [
                    'name' => 'required',
                    'email' => [
                        'required',
                        'regex:/^([\w\.\-]+)@([\w\-]+\.)+[\w\-]{2,4}$/'
                    ],
                ]
            );

            if ($validator->fails()) {
                $errors[] = [
                    'row' => $rowNumber,
                    'error' => implode(', ', $validator->errors()->all())
                ];
                continue;
            }

            // Append the validated row
            $validatedRows[] = [
                'name' => $row[0],
                'email' => $row[1],
                'placementId' => $placementId
                // add additional fields from the row if necessary
            ];
        }

        // Debugging: Uncomment this if you need to check validated rows after the loop


        // If there are any validation errors, return them as a JSON response
        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ]);
        }


        // Dispatch a background job to import candidates
        dispatch(new ImportCandidate($validatedRows, $collegeId, $placementId));

        return response()->json([
            'success' => true,
            'message' => 'Candidates are being imported in the background.',
            'total' => count($validatedRows),
        ]);
    }


    public function collegePlacementList(Request $request, $collegeId)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 50;
        // $query = PlacementColleges::query()
        //     ->join('placement', 'placement.id', '=', 'placement_college.id')
        //     // ->where('is_active', true)
        //     ->when($search, function ($query) use ($search) {
        //         return $query->where('placement.name', 'like', "%{$search}%");
        //     });

        // $quizzes = $query->paginate($perPage, ['*'], 'page', $page);

        $query = PlacementColleges::query()
            ->join('placement', 'placement.id', '=', 'placement_college.placement_id')
            ->select([
                'placement.name',
                'placement.description',
                'placement_college.college_acceptance',
                'placement.created_at',
                'placement.id',

            ])
            ->where('placement.status', 1)
            ->where('placement_college.college_id', $collegeId)
            ->when($search, function ($query, $search) {
                return $query->where('placement.name', 'like', "%{$search}%")
                    ->orWhere('placement.description', 'like', "%{$search}%");
            })
            ->orderBy('placement.created_at', 'desc');

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        // Format created_at with Carbon
        $paginator->getCollection()->transform(function ($item) {
            $item->formatted_created_at = Carbon::parse($item->created_at)->diffForHumans();
            return $item;
        });





        return response()->json([
            'data' => $paginator->items(),
            'next_page_url' => $paginator->nextPageUrl(),
            'total' => $paginator->total()
        ]);
    }

    public function collegePlacementDetails(Request $reques)
    {
        return view('recruitment::college.drives.assignedDrive');
    }


    public function assignedCandidates($placementId)
    {
        try {
            // Get the authenticated college ID
            $collegeId = Auth::guard('college')->user()->id;

            // Pagination and search parameters
            $perPage = request('per_page', 10);
            $search = request('search');

            // Query to fetch candidates for a specific placement_id and college_id
            $collegeCandidateQuery = CollegeCandidatePlacement::query()
                ->join('college_candidates', 'college_candidates.id', '=', 'college_candidate_placements.college_candidate_id')
                ->join('candidate_users', 'candidate_users.id', '=', 'college_candidates.candidate_id')
                ->where('college_candidate_placements.placement_id', $placementId)
                ->where('college_candidates.college_id', $collegeId)
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('candidate_users.name', 'like', "%{$search}%")
                            ->orWhere('candidate_users.email', 'like', "%{$search}%");
                    });
                })
                ->select(
                    'college_candidate_placements.placement_id',
                    'college_candidates.id as college_candidate_id',
                    'candidate_users.id as candidate_id',
                    'candidate_users.name as candidate_name',
                    'candidate_users.email as candidate_email'
                );

            // Paginate the results
            $collegeCandidate = $collegeCandidateQuery->paginate($perPage)->appends(request()->query());

            // Debugging (optional, remove in production)
            // dd($collegeCandidates);

            // Return the view with the paginated data
            return view('recruitment::college.drives.college-candidate', compact('collegeCandidate', 'placementId'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Placement not found: ' . $e->getMessage());
        }
    }


    public function assignedPlacementCandidate(Request $request)
    {


        $collegeId = Auth::guard('college')->user()->id;



        dispatch(new PlacementAssigned(
            $request->candidates,
            $request->placementId,
            $collegeId
        ));

        return response()->json([
            'success' => true,
            'message' => 'Candidates are being imported in the background.',

        ]);
    }

    // public function showPlacementDetail($placementId)
    // {

    //     $placement = Placements::with([
    //         'educationLevel',
    //         'placementDegrees.degree',
    //         'placementSkills.skill'
    //     ])->find($placementId);



    //     return view('Recruitment::college.drives.placement-detail', compact('placement'));
    // }

    public function showPlacementDetail($placementId)
    {
        // Step 1: Get logged-in college ID
        $collegeUser = Auth::guard('college')->user();
        if (!$collegeUser) {
            abort(401, 'You must be logged in as a college user.');
        }
        $collegeId = $collegeUser->college ? $collegeUser->college->id : $collegeUser->id;

        // Step 2: Check if placement is assigned to this college (regardless of acceptance status)
        $placementCollege = \Modules\Recruitment\Models\Placement\PlacementColleges::where([
            'college_id' => $collegeId,
            'placement_id' => $placementId
        ])->first();

        if (!$placementCollege) {
            abort(403, 'You are not authorized to view this placement.');
        }

        // Step 3: Load placement details
        $placement = Placements::with([
            'educationLevel',
            'placementDegrees.degree',
            'placementSkills.skill'
        ])->findOrFail($placementId);

        // Optionally, pass the acceptance status to the view
        return view('Recruitment::college.drives.placement-detail', compact('placement', 'placementCollege'));
    }


    public function verificationStatus()
    {
        $college = auth()->guard('college')->user();
        return response()->json(['verified' => $college->is_verified]);
    }


    public function collegeCandidates(Request $request)
    {
        try {
            $collegeId = Auth::guard('college')->user()->id;
            $search = $request->get('search');



            // $query = CollegeCandidate::with(['candidate' => function($q) use ($search) {
            //         if (!empty($search) && isset($search)) {
            //             $q->where('name', 'like', "%{$search}%")
            //               ->orWhere('email', 'like', "%{$search}%");
            //         }
            //     }])
            //     ->where('college_id', $collegeId)
            //     ->orderBy('created_at', 'asc');

            // $candidates = $query->paginate(20);

            $collegeCandidate = CollegeCandidate::join('candidate_users', 'candidate_users.id', '=', 'college_candidates.candidate_id')
                ->where('college_candidates.college_id', $collegeId)
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('candidate_users.name', 'like', "%{$search}%")
                            ->orWhere('candidate_users.email', 'like', "%{$search}%");
                    });
                })
                ->select(
                    'candidate_users.name as candidate_name',
                    'candidate_users.email as candidate_email',
                    'candidate_users.id as candidate_id'
                )
                ->paginate(20)
                ->appends(request()->query());



            return response()->json([
                'data' => $collegeCandidate->map(function ($item) {
                    return [
                        'candidate_id' => $item->candidate_id,
                        'candidate_name' => $item->candidate_name,
                        'candidate_email' => $item->candidate_email
                    ];
                }),
                'current_page' => $collegeCandidate->currentPage(),
                'last_page' => $collegeCandidate->lastPage(),
                'total' => $collegeCandidate->total()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load candidates',
                'message' => $e->getMessage() // Remove in production
            ], 500);
        }
    }



    public function assignInsertPlacementCandidates(Request $request)
    {

        $validated = $request->validate([
            'placement_id' => 'required|exists:placement,id',
            'candidates' => 'required|array',
            'candidates.*.name' => 'required|string|max:255',
            'candidates.*.email' => 'required|email|max:255',
        ]);


        $collegeId = Auth::guard('college')->user()->id;
        $placementId = $request->placement_id;

        dispatch(new ImportCandidate($validated['candidates'], $collegeId, $placementId));

        return response()->json([
            'success' => true,
            'message' => 'Candidates are in process to assign its perticuler drive.',
            'total' => count($validated),
        ]);
    }
}
