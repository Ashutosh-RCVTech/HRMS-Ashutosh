<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Recruitment\Services\CandidateDashboardService;

class DashboardController extends Controller
{
    public function __construct(protected CandidateDashboardService $candidateDashboardService) {}

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'work_location' => $request->input('filters.work_location'),
            'experience' => $request->input('filters.experience_required'),
            'salary_type' => $request->input('filters.salary_type'),
            'min_salary' => $request->input('filters.min_salary', 0),
            'max_salary' => $request->input('filters.max_salary', 9000000),
            'job_type' => $request->input('filters.job_type', []),
            'schedule' => $request->input('filters.schedule', []),
            'skills' => $request->input('filters.skills', []),
        ];

        $data = $this->candidateDashboardService->getDashboardData($filters);

        return view('recruitment::candidate.dashboard', $data);
    }
}
