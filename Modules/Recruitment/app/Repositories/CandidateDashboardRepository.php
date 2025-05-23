<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\JobOpening;
use Modules\Recruitment\Models\Location;

class CandidateDashboardRepository
{
    public function getFilteredJobs(array $filters)
    {
        // Convert location names to IDs if they are provided as names
        if (!empty($filters['work_location']) && !is_array($filters['work_location'])) {
            $filters['work_location'] = Location::whereIn('name', (array) $filters['work_location'])
                ->pluck('id')
                ->toArray();
        }

        return JobOpening::latest()
            ->where('status', 'open')
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when(!empty($filters['work_location']), function ($query) use ($filters) {
                $query->whereHas('locations', function ($subQuery) use ($filters) {
                    $subQuery->whereIn('locations.id', (array) $filters['work_location']); // Explicit table reference
                });
            })
            // ->when($filters['experience'] ?? null, function ($query, $experience) {
            //     $query->where('experience_required', $experience);
            // })
            ->when(!empty($filters['experience']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    foreach ((array) $filters['experience'] as $experienceRange) {
                        [$minExp, $maxExp] = $this->parseExperienceRange($experienceRange);
                        $q->orWhereBetween('experience_required', [$minExp, $maxExp]);
                    }
                });
            })
            ->when($filters['salary_type'] ?? null, function ($query, $salaryType) {
                $query->where('salary_type', $salaryType);
            })
            ->when(isset($filters['min_salary']) || isset($filters['max_salary']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $minSalary = $filters['min_salary'] ?? 0;
                    $maxSalary = $filters['max_salary'] ?? 9000;
                    $q->whereBetween('min_salary', [$minSalary, $maxSalary])
                        ->orWhereBetween('max_salary', [$minSalary, $maxSalary])
                        ->orWhereRaw('? BETWEEN min_salary AND max_salary', [$minSalary])
                        ->orWhereRaw('? BETWEEN min_salary AND max_salary', [$maxSalary]);
                });
            })
            ->when(!empty($filters['job_type']), function ($query) use ($filters) {
                $query->whereHas('jobTypes', function ($subQuery) use ($filters) {
                    $subQuery->whereIn('job_types.id', $filters['job_type']);
                });
            })
            ->when(!empty($filters['schedule']), function ($query) use ($filters) {
                $query->whereHas('schedules', function ($subQuery) use ($filters) {
                    $subQuery->whereIn('schedules.id', $filters['schedule']);
                });
            })
            ->when(!empty($filters['skills']), function ($query) use ($filters) {
                $query->whereHas('skills', function ($subQuery) use ($filters) {
                    $subQuery->whereIn('skills.id', $filters['skills']);
                });
            })
            ->get();
    }

    private function parseExperienceRange($experienceRange)
    {
        if (str_contains($experienceRange, '-')) {
            [$minExp, $maxExp] = explode('-', str_replace(['Years', ' '], '', $experienceRange));
            return [(int)$minExp, (int)$maxExp];
        } elseif (str_contains($experienceRange, '5+')) {
            return [5, 50]; // Assuming 5+ means 5 to a large upper limit
        }
        return [(int)$experienceRange, (int)$experienceRange]; // Default case
    }
}
