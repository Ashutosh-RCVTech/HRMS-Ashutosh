<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Recruitment\Services\CandidateJobApplicationService;


class JobApplicationController extends Controller
{
    protected $jobApplicationService;

    public function __construct(CandidateJobApplicationService $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    /**
     * Display a listing of the candidate's job applications
     */
    public function index(Request $request)
    {
        $candidateId = auth()->guard('candidate')->id();

        // Get filter inputs
        $status = $request->input('status');
        $search = $request->input('search');
        $sortColumn = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        // Build filters array
        $filters = [];
        if ($status) {
            $filters['status'] = $status;
        }

        // Get paginated results
        $applications = $this->jobApplicationService->searchAndFilterApplications(
            $filters,
            $search,
            $sortColumn,
            $sortDirection
        );

        // Get status counts for the sidebar
        $statusCounts = $this->jobApplicationService->getStatusCounts($candidateId);

        return view('recruitment::candidate.applications.index', compact(
            'applications',
            'statusCounts',
            'status',
            'search',
            'sortColumn',
            'sortDirection'
        ));
    }

    /**
     * Display the specified job application
     */
    public function show($id)
    {
        $application = $this->jobApplicationService->getApplicationDetails($id);

        // Check if the application belongs to the authenticated candidate
        $candidateId = auth()->guard('candidate')->id();
        if ($application->candidate_id != $candidateId) {
            abort(403, 'Unauthorized action.');
        }

        return view('recruitment::candidate.applications.show', compact('application'));
    }

    /**
     * Withdraw a job application
     */
    public function withdraw($id)
    {
        $application = $this->jobApplicationService->getApplicationDetails($id);

        // Check if the application belongs to the authenticated candidate
        $candidateId = auth()->guard('candidate')->id();
        if ($application->candidate_id != $candidateId) {
            abort(403, 'Unauthorized action.');
        }

        $this->jobApplicationService->withdrawApplication($id);

        return redirect()->route('candidate.applications.index')
            ->with('success', 'Application withdrawn successfully.');
    }
}
