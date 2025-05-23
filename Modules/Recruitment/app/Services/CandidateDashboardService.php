<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\CandidateDashboardRepository;
use Modules\Recruitment\Models\JobType;
use Modules\Recruitment\Models\Schedule;
use Modules\Recruitment\Models\Skill;
use Modules\Recruitment\Models\Location;

class CandidateDashboardService
{
    public function __construct(protected CandidateDashboardRepository $candidateDashboardRepository) {}

    public function getDashboardData(array $filters)
    {
        return [
            'jobs' => $this->candidateDashboardRepository->getFilteredJobs($filters),
            'experiences' => ['0-1 Years', '1-3 Years', '3-5 Years', '5+ Years'],
            'jobTypes' => JobType::all(),
            'schedules' => Schedule::all(),
            'skills' => Skill::all(),
            'locations' => Location::pluck('name', 'id'),
        ];
    }
}
