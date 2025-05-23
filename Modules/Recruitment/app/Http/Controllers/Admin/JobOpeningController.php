<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Recruitment\Models\JobOpening;
use Modules\Recruitment\Services\SkillService;
use Modules\Recruitment\Services\ClientService;
use Modules\Recruitment\Services\DegreeService;
use Modules\Recruitment\Services\BenefitService;
use Modules\Recruitment\Services\JobTypeService;
use Modules\Recruitment\Services\ScheduleService;
use Modules\Recruitment\Services\JobOpeningService;
use Modules\Recruitment\Services\EducationLevelService;
use Modules\Recruitment\Services\JobDescriptionGeneratorService;
use Modules\Recruitment\Services\LocationService;

class JobOpeningController extends Controller
{
    public function __construct(
        protected JobOpeningService $jobOpeningService,
        protected SkillService $skillService,
        protected EducationLevelService $educationLevelService,
        protected BenefitService $benefitService,
        protected ScheduleService $scheduleService,
        protected JobTypeService $jobTypeService,
        protected DegreeService $degreeService,
        protected ClientService $clientService,
        protected LocationService $locationService,
        protected JobDescriptionGeneratorService $jobDescriptionGeneratorService,
    ) {}

    /**
     * List and filter job openings
     */
    public function index(Request $request)
    {
        $filters = [
            'status' => $request->input('filters.status', ''),
            'experience_required' => $request->input('filters.experience_required', ''),
        ];

        $jobOpenings = $this->jobOpeningService->listJobOpenings(
            $filters,
            $request->input('search', '') ?? '',
            $request->input('sort_column', 'created_at'),
            $request->input('sort_direction', 'desc'),
            $request->input('per_page', 10)
        );

        if ($request->has('reset')) {
            return redirect()->route('admin.jobs.index');
        }

        return view('recruitment::admin.jobs.index', [
            'jobOpenings' => $jobOpenings,
            'filters' => $filters,
            'searchQuery' => $request->input('search', ''),
            'sortColumn' => $request->input('sort_column', 'created_at'),
            'sortDirection' => $request->input('sort_direction', 'desc'),
        ]);
    }

    /**
     * Show job creation form
     */
    public function create()
    {
        return view('recruitment::admin.jobs.create', $this->getJobFormOptions());
    }

    /**
     * Store a new job opening
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateJobOpening($request);
            $validated['user_id'] = Auth::id();

            // Add status to validated data, defaulting to 'draft' if not specified
            $validated['status'] = $request->input('status', 'draft');

            // Process skill_ids
            if (!empty($validated['skill_ids'])) {
                $skills = is_array($validated['skill_ids'])
                    ? explode(',', $validated['skill_ids'][0])
                    : explode(',', $validated['skill_ids']);
                $validated['skills'] = array_filter($skills);
            }

            // Map the field names correctly
            $validated['job_types'] = $request->input('selected_job_types', []);
            $validated['schedules'] = $request->input('selected_schedules', []);
            $validated['benefits'] = $request->input('selected_benefits', []);
            $validated['locations'] = $request->input('selected_locations', []);

            $this->jobOpeningService->createJobOpening($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'true',
                    'message' => $validated['status'] === 'draft'
                        ? 'Job draft saved successfully'
                        : 'Job opening created successfully',
                    'redirect' => route('admin.jobs.index')
                ]);
            }
            return redirect()->route('admin.jobs.index')
                ->with('success', $validated['status'] === 'draft'
                    ? 'Job draft saved successfully'
                    : 'Job opening created successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show job editing form
     */
    public function edit($id)
    {
        return $this->handleException(function () use ($id) {
            $job = $this->jobOpeningService->getJobOpeningById($id);

            // Explicitly format the application_deadline
            $job->application_deadline = $job->application_deadline
                ? $job->application_deadline->format('Y-m-d')
                : null;

            // Include related data for the form
            $formOptions = $this->getJobFormOptions();
            $formOptions['job'] = $job;

            // Pass the related data (skills, job types, schedules, benefits) for editing
            $formOptions['selected_skills'] = $job->skills->pluck('id')->toArray() ?: [];
            $formOptions['selected_job_types'] = $job->jobTypes->pluck('id')->toArray();
            $formOptions['selected_schedules'] = $job->schedules->pluck('id')->toArray();
            $formOptions['selected_benefits'] = $job->benefits->pluck('id')->toArray();
            $formOptions['selected_locations'] = $job->locations->pluck('id')->toArray();

            return view('recruitment::admin.jobs.edit', $formOptions);
        });
    }

    /**
     * Update an existing job opening
     */

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $validated = $this->validateJobOpening($request);

    //         // Process skill_ids into skills array
    //         if (!empty($validated['skill_ids'])) {
    //             $skills = is_array($validated['skill_ids'])
    //                 ? explode(',', $validated['skill_ids'][0])
    //                 : explode(',', $validated['skill_ids']);
    //             $validated['skills'] = array_filter($skills);
    //         }

    //         $this->jobOpeningService->updateJobOpening($validated, $id);

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Job opening updated successfully',
    //                 'redirect' => route('admin.jobs.index')
    //             ]);
    //         }

    //         return redirect()->route('admin.jobs.index')
    //             ->with('success', 'Job opening updated successfully');
    //     } catch (\Exception $e) {
    //         Log::error('Error updating Job opening: ' . $e->getMessage());

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $e->getMessage()
    //             ], 422);
    //         }

    //         return back()->with('error', $e->getMessage());
    //     }
    // }

    //Updated method to reolve the issue of not updating the status of draft job opening...
    public function update(Request $request, $id)
    {
        try {
            $validated = $this->validateJobOpening($request);

            // Ensure the 'status' (e.g., "draft" or "published") is captured
            $validated['status'] = $request->input('status', 'draft');

            // Process skill_ids into skills array
            if (!empty($validated['skill_ids'])) {
                $skills = is_array($validated['skill_ids'])
                    ? explode(',', $validated['skill_ids'][0])
                    : explode(',', $validated['skill_ids']);
                $validated['skills'] = array_filter($skills);
            }

            // Map the field names correctly
            $validated['job_types'] = $request->input('selected_job_types', []);
            $validated['schedules'] = $request->input('selected_schedules', []);
            $validated['benefits'] = $request->input('selected_benefits', []);
            $validated['locations'] = $request->input('selected_locations', []);

            $this->jobOpeningService->updateJobOpening($validated, $id);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $validated['status'] === 'draft'
                        ? 'Job draft updated successfully'
                        : 'Job opening updated successfully',
                    'redirect' => route('admin.jobs.index')
                ]);
            }

            return redirect()->route('admin.jobs.index')
                ->with('success', $validated['status'] === 'draft'
                    ? 'Job draft updated successfully'
                    : 'Job opening updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating Job opening: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }


    /**
     * Delete a job opening
     */
    public function destroy($id)
    {
        return $this->handleException(function () use ($id) {
            $this->jobOpeningService->deleteJobOpening($id);

            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job opening deleted successfully');
        });
    }
    /**
     * Show a job opening
     */
    public function show($id)
    {
        return $this->handleException(function () use ($id) {
            $job = $this->jobOpeningService->getJobOpeningById($id);

            if (!$job) {
                return redirect()->route('admin.jobs.index')
                    ->with('error', 'Job not found');
            }

            return view('recruitment::admin.jobs.show', [
                'job' => $job,
            ]);
        });
    }


    /**
     * Get skills based on search query
     */
    public function getSkills(Request $request)
    {
        return $this->handleException(function () use ($request) {
            $searchItem = $request->input('searchItem', '');
            $page = $request->input('page', 1);

            $data = $this->skillService->searchSkills($searchItem, $page);

            return response()->json([
                'data' => $data->items(),
                'last_page' => $data->lastPage(),
            ]);
        });
    }

    /**
     * Validate job opening data
     */
    private function validateJobOpening(Request $request)
    {
        $rules = [
            'title' => 'required_if:status,published|string|max:255',
            'description' => 'required_if:status,published|string',
            'client' => 'required_if:status,published|string',
            'no_of_openings' => 'required_if:status,published|integer|min:1',
            'experience_required' => [
                'required_if:status,published',
                'string',
                'in:' . implode(',', array_keys(\Modules\Recruitment\Models\JobOpening::getExperienceRanges())),
            ],
            'min_salary' => 'required_if:status,published|numeric',
            'max_salary' => 'required_if:status,published|numeric',
            'required_skills' => 'nullable|string',
            'location_type' => 'nullable|string',
            'job_type_id' => 'nullable|exists:job_types,id',
            'education_level' => 'required_if:status,published|string',
            'degree' => 'required_if:status,published|string',
            'status' => 'in:draft,published,open,closed',
            'application_deadline' => 'nullable|date|after:today',
            'selected_job_types' => 'array',
            'selected_schedules' => 'array',
            'selected_benefits' => 'array',
            'selected_locations' => 'array',
            'skill_ids' => 'nullable'
        ];

        $messages = [
            'experience_required.required_if' => 'Experience Required: Please select experience range',
            'experience_required.in' => 'Experience Required: Please select experience range'
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Get options for job creation/edit form
     */
    private function getJobFormOptions()
    {
        return [
            'educationLevels' => $this->educationLevelService->getAllEducationLevels(),
            'jobTypes' => $this->jobTypeService->getAllJobTypes(),
            'schedules' => $this->scheduleService->getAllSchedules(),
            'benefits' => $this->benefitService->getAllBenefits(),
            'degrees' => $this->degreeService->getAllDegrees(),
            'clients' => $this->clientService->getAllClients()->get(),
            'locations' => $this->locationService->getAllLocations(),
            'experienceRanges' => \Modules\Recruitment\Models\JobOpening::getExperienceRanges()
        ];
    }

    /**
     * Toggle the status
     */
    public function toggleStatus(JobOpening $job)
    {
        try {
            $job->status = $job->status === 'open' ? 'closed' : 'open';
            $job->save();

            return response()->json([
                'success' => true,
                'message' => 'Job status updated successfully!',
                'status' => $job->status,
            ]);
        } catch (\Exception $e) {
            Log::error('Job status toggle error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update job status.',
            ], 500);
        }
    }

    /**
     * Handle exceptions in reusable way
     */
    private function handleException(\Closure $callback)
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Method for AI description generation
    public function generateDescription(Request $request)
    {
        Log::info('Generate AI Description Request', $request->all());

        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'client' => 'required|string',
                'experience' => 'required|string',
                'skills' => 'required|array|min:1',
                'skills.*' => 'string',
                'education_level' => 'required|string',
                'degree' => 'required|string',
            ]);

            $descriptionGenerator = new JobDescriptionGeneratorService();
            $description = $descriptionGenerator->generateDescription($validatedData);

            return response()->json([
                'description' => $description
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return the first validation error message
            $errorMsg = collect($e->errors())->flatten()->first() ?: 'Validation error.';
            return response()->json([
                'error' => $errorMsg
            ], 422);
        } catch (\InvalidArgumentException $e) {
            // Return service validation errors
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            Log::error('AI Description Generation Error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
