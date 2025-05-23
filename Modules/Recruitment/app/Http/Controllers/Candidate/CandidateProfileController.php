<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Http\Resources\CandidateResource;
use Modules\Recruitment\Services\Interfaces\IFileUploadService;
use Modules\Recruitment\Services\Interfaces\ICandidateProfileService;
use Modules\Recruitment\Http\Requests\Candidate\UpdateCandidateEducationRequest;
use Modules\Recruitment\Http\Requests\Candidate\UpdateCandidateEmploymentRequest;
use Modules\Recruitment\Http\Requests\Candidate\UpdateCandidateBasicDetailsRequest;
use Modules\Recruitment\Http\Requests\Candidate\UpdateCandidateCareerProfileRequest;
use Modules\Recruitment\Models\College;
use Illuminate\Support\Facades\Log;

class CandidateProfileController extends Controller
{
    protected $candidateProfileService;
    protected $fileUploadService;

    public function __construct(
        ICandidateProfileService $candidateProfileService,
        IFileUploadService $fileUploadService
    ) {
        $this->candidateProfileService = $candidateProfileService;
        $this->fileUploadService = $fileUploadService;
    }

    protected function guard()
    {
        return Auth::guard('candidate');
    }

    public function edit()
    {
        $candidate = $this->candidateProfileService->getCandidateProfile($this->guard()->id());

        // Section completion checks
        $basicCompleted = $candidate['candidate']->basicDetail && $candidate['candidate']->name;
        $educationCompleted = $candidate['candidate']->educations && $candidate['candidate']->educations->isNotEmpty();

        return view('recruitment::candidate.profile.edit', array_merge($candidate, [
            'sectionCompletion' => [
                'basic' => $basicCompleted,
                'education' => $educationCompleted,
            ]
        ]));
    }

    public function updateBasicDetails(UpdateCandidateBasicDetailsRequest $request)
    {
        try {
            $validated = $request->validated();
            $candidateId = $this->guard()->id();
            
            // Update CandidateUser's name
            $candidate = CandidateUser::findOrFail($candidateId);
            $candidate->name = $validated['name'];
            $candidate->save();

            // Handle file uploads
            $fileData = $this->handleFileUploads($request);

            // Prepare basic detail data (exclude 'name')
            $basicDetailData = array_merge(
                collect($validated)->except(['name'])->toArray(),
                $fileData
            );

            // Validate all required fields for basic details (exclude 'name')
            $requiredFields = ['location', 'mobile', 'resume_headline', 'key_skills', 'it_skills', 'profile_summary'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (empty($basicDetailData[$field])) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please fill in all required fields',
                    'errors' => array_fill_keys($missingFields, ['This field is required'])
                ], 422);
            }

            $basicDetail = $this->candidateProfileService->updateBasicDetails(
                $candidateId,
                $basicDetailData
            );

            // Check if profile is complete
            $this->checkProfileCompletion($candidateId);

            return response()->json([
                'success' => true,
                'message' => 'Basic details updated successfully',
                'basic_detail' => $basicDetail
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function updateEducation(UpdateCandidateEducationRequest $request)
    {
        
  

        try {
            $educations = $this->candidateProfileService->updateEducation(
                $this->guard()->id(),
                $request->validated()['educations']
            );

            // Check if profile is complete
            $this->checkProfileCompletion($this->guard()->id());

            return response()->json([
                'success' => true,
                'message' => 'Education details updated successfully',
                'educations' => $educations
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function searchCollege(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = College::query()
            // ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });

        $colleges = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $colleges->items(),
            'next_page_url' => $colleges->nextPageUrl(),
            'total' => $colleges->total()
        ]);
    }
    public function updateEmployment(UpdateCandidateEmploymentRequest $request)
    {
        try {
            $employments = $this->candidateProfileService->updateEmployment(
                $this->guard()->id(),
                $request->validated()['employments']
            );

            return response()->json([
                'success' => true,
                'message' => 'Employment details updated successfully',
                'employments' => $employments
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function updateCareerProfile(UpdateCandidateCareerProfileRequest $request)
    {
        try {
            $careerProfile = $this->candidateProfileService->updateCareerProfile(
                $this->guard()->id(),
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Career profile updated successfully',
                'career_profile' => $careerProfile
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    protected function handleFileUploads(Request $request): array
    {
        $fileData = [];

        if ($request->hasFile('profile_image')) {
            $fileData['profile_image_path'] = $this->fileUploadService->upload(
                $request->file('profile_image'),
                'candidate/profile-images'
            );
        }

        if ($request->hasFile('resume')) {
            $fileData['resume_path'] = $this->fileUploadService->upload(
                $request->file('resume'),
                'candidate/resumes'
            );
        }

        return $fileData;
    }

    private function handleException(\Exception $e)
    {
        Log::error('Candidate Profile Error: ' . $e->getMessage());
        
        if ($e instanceof \Illuminate\Database\QueryException) {
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while saving your profile. Please try again.',
            'error' => $e->getMessage()
        ], 500);
    }

    // protected function checkProfileCompletion($candidateId)
    // {
    //     $candidate = CandidateUser::find($candidateId);
    //     $basicDetail = $candidate->basicDetail;
    //     $educations = $candidate->educations;

    //     // Check if basic details and education are completed
    //     if ($basicDetail && $educations->isNotEmpty()) {
    //         $candidate->update(['profile_completed' => true]);
    //     }
    // }

    // protected function checkProfileCompletion($candidateId)
    // {
    //     // Use guard to get the current authenticated candidate user
    //     $candidate = $this->guard()->user();

    //     $basicDetail = $candidate->basicDetail;
    //     $educations = $candidate->educations;

    //     // Check if basic details and education are completed
    //     if ($basicDetail && $educations->isNotEmpty()) {
    //         $candidate->update(['profile_completed' => true]);
    //     } else {
    //         $candidate->update(['profile_completed' => false]);
    //     }
    // }

    protected function checkProfileCompletion($candidateId)
    {
        $candidate = CandidateUser::find($candidateId);
        $basicDetail = $candidate->basicDetail;
        $educations = $candidate->educations;

        // Check if name is provided and other basic details exist
        $nameProvided = !empty($candidate->name);
        $profileCompleted = $nameProvided && $basicDetail && $educations->isNotEmpty();

        $candidate->update(['profile_completed' => $profileCompleted]);
    }
}
