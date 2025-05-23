<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Recruitment\Models\JobApplication;
use Modules\Recruitment\Models\JobOpening;
use Modules\Recruitment\Services\JobOpeningService;

class JobOpeningController extends Controller
{
    /**
     * Constructor
     *
     * @param JobOpeningService $jobOpeningService
     */
    public function __construct(protected JobOpeningService $jobOpeningService)
    {
        $this->jobOpeningService = $jobOpeningService;
    }

    /**
     * Display a listing of job openings with filtering and pagination
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {
        // Validate and sanitize input
        $validatedData = $request->validate([
            'search' => 'nullable|string|max:255',
            'location' => 'nullable|exists:locations,id',
            'experience' => 'nullable|string',
            'job_type' => 'nullable|exists:job_types,id',
            'salary_range' => 'nullable|string',
            'job_freshness' => 'nullable|integer',
            'sort' => 'nullable|string|in:created_at-desc,created_at-asc,title-asc,title-desc'
        ]);

        // Prepare filters
        $filters = [];

        // Location filter
        if (!empty($validatedData['location'])) {
            $filters['location'] = $validatedData['location'];
        }

        // Experience filter
        if (!empty($validatedData['experience'])) {
            $experienceFilter = $validatedData['experience'];

            if (strpos($experienceFilter, '+') !== false) {
                // Handle cases like '8+'
                $expMin = (int) str_replace('+', '', $experienceFilter);
                $filters['experience_min'] = $expMin;
            } else {
                $expRange = explode('-', $experienceFilter);
                $filters['experience_min'] = (int) $expRange[0];
                $filters['experience_max'] = isset($expRange[1]) ? (int) $expRange[1] : null;
            }
        }

        // Job Type filter
        if (!empty($validatedData['job_type'])) {
            $filters['job_type'] = $validatedData['job_type'];
        }

        // Salary Range filter
        if (!empty($validatedData['salary_range'])) {
            $filters['salary_range'] = $validatedData['salary_range'];
        }

        // Job Freshness filter
        if (!empty($validatedData['job_freshness'])) {
            $filters['job_freshness'] = $validatedData['job_freshness'];
        }

        // Parse sort parameter (column-direction)
        $sort = $validatedData['sort'] ?? 'created_at-desc';
        list($sortColumn, $sortDirection) = explode('-', $sort);

        // Get jobs with filters
        $jobs = $this->jobOpeningService->listJobOpenings(
            filters: $filters,
            searchQuery: $validatedData['search'] ?? '',
            sortColumn: $sortColumn,
            sortDirection: $sortDirection,
            perPage: 6,
            page: $request->get('page', 1)
        );

        // Get filter options
        $filterOptions = $this->jobOpeningService->getFilterOptions();
        $locations = $filterOptions['locations'];
        $jobTypes = $filterOptions['jobTypes'];
        $schedules = $filterOptions['schedules'];

        // Handle AJAX requests
        if ($request->ajax()) {
            $html = view('recruitment::candidate.jobs.partials.job_listings', compact('jobs'))->render();
            $pagination = view('recruitment::candidate.jobs.partials.pagination', compact('jobs'))->render();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
                'totalCount' => $jobs->total(),
                'currentPage' => $jobs->currentPage(),
                'lastPage' => $jobs->lastPage()
            ]);
        }

        // Return full view for non-AJAX requests
        return view('recruitment::candidate.jobs.index', compact(
            'jobs',
            'locations',
            'jobTypes',
            'schedules'
        ));
    }

    /**
     * Display job opening details
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    // public function show($id)
    // {
    //     $job = $this->jobOpeningService->getJobOpeningById($id);

    //     if (!$job) {
    //         abort(404, 'Job opening not found');
    //     }

    //     // Check if user has already applied
    //     $hasApplied = false;
    //     if (Auth::check()) {
    //         // $hasApplied = JobApplication::where('job_opening_id', $id)
    //         //     ->where('user_id', Auth::id())
    //         //     ->exists();

    //         $hasApplied = JobApplication::where('job_id', $id)
    //             ->where('candidate_id', Auth::guard('candidate')->id())
    //             ->exists();
    //     }

    //     return view('recruitment::candidate.jobs.show', compact('job', 'hasApplied'));
    // }

    public function show($id)
    {
        $job = $this->jobOpeningService->getJobOpeningById($id);

        if (!$job) {
            abort(404, 'Job opening not found');
        }

        // Only allow "open" jobs to be viewed by candidates
        if ($job->status !== 'open') {
            return view('recruitment::candidate.jobs.unavailable', [
                'message' => 'This job is not available for viewing.'
            ]);
        }

        // Check if user has already applied
        $hasApplied = false;
        if (Auth::guard('candidate')->check()) {
            $hasApplied = \Modules\Recruitment\Models\JobApplication::where('job_id', $id)
                ->where('candidate_id', Auth::guard('candidate')->id())
                ->exists();
        }

        return view('recruitment::candidate.jobs.show', compact('job', 'hasApplied'));
    }


    /**
     * Search job titles for autocomplete
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('query', '');
        $titles = $this->jobOpeningService->searchJobTitles($query);

        return response()->json([
            'success' => true,
            'results' => $titles->pluck('title')
        ]);
    }

    /**
     * Apply for a job
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apply(Request $request, $id)
    {
        try {
            $job = $this->jobOpeningService->getJobOpeningById($id);

            if (!$job) {
                return response()->json(['error' => 'Job not found'], 404);
            }

            $request->validate([
                'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
                'cover_letter' => 'nullable|string|max:2000'
            ]);

            // Check existing application
            $existing = JobApplication::where('job_id', $id)
                ->where('candidate_id', Auth::guard('candidate')->id())
                ->exists();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already applied to this position'
                ], 409);
            }

            // Store file
            $resumePath = $request->file('resume')->store('resumes', 'public');

            // Create application
            $application = JobApplication::create([
                'job_id' => $id,
                'candidate_id' => Auth::guard('candidate')->id(),
                'resume_path' => $resumePath,
                'cover_letter' => $request->cover_letter,
                'status' => 'applied'
            ]);

            return response()->json([
                'success' => true,
                'redirect' => route('candidate.applications.index'),
                'message' => 'Application submitted!'
            ]);
        } catch (\Exception $e) {
            Log::error('Application Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display user's applied jobs
     *
     * @return \Illuminate\View\View
     */
    public function applied()
    {
        $applications = JobApplication::with('jobOpening')
            ->where('candidate_id', Auth::guard('candidate')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('recruitment::candidate.applications.index', compact('applications'));
    }

    /**
     * Withdraw job application
     *
     * @param int $applicationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdraw($applicationId)
    {
        $application = JobApplication::where('id', $applicationId)
            ->where('candidate_id', Auth::id())
            ->first();

        if (!$application) {
            abort(404, 'Application not found');
        }

        // Only allow withdrawal if status is pending or under review
        if (in_array($application->status, ['pending', 'under_review'])) {
            $application->status = 'withdrawn';
            $application->save();

            return back()->with('success', 'Your application has been withdrawn.');
        }

        return back()->with('error', 'This application cannot be withdrawn at this time.');
    }




    public function showDetails(JobOpening $job)
    {
        $job->load(['skills', 'locations']);

        if (auth('candidate')->check()) {
            $job->load(['application' => function ($query) {
                $query->where('candidate_id', auth('candidate')->id());
            }]);
        }

        return view('recruitment::candidate.jobs.partials.job_details', [
            'job' => $job,
            'isBookmarked' => auth('candidate')->check()
                ? $job->isBookmarkedByCandidate(auth('candidate')->id())
                : false
        ]);
    }

    // public function showDetails(JobOpening $job)
    // {
    //     $job->load(['skills', 'locations']);

    //     return view('recruitment::candidate.jobs.partials.job_details', [
    //         'job' => $job,
    //         'isBookmarked' => auth('candidate')->check()
    //             ? $job->isBookmarkedByCandidate(auth('candidate')->id())
    //             : false
    //     ]);
    // }
}
