<?php

namespace Modules\Recruitment\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Modules\Recruitment\Models\JobOpening;

class JobOpeningRepository extends BaseRepository
{
    /**
     * @param JobOpening $model
     */
    public function __construct(JobOpening $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active job openings with optional filters
     *
     * @param array $filters
     * @return Collection
     */
    public function getActiveJobOpenings(array $filters = []): Collection
    {
        $query = $this->model->active();

        foreach ($filters as $key => $value) {
            if ($value) {
                $query->where($key, $value);
            }
        }

        return $query->get();
    }

    /**
     * Get job openings by department
     *
     * @param string $department
     * @return Collection
     */
    public function getJobOpeningsByDepartment(string $department): Collection
    {
        return $this->model->where('department', $department)
            ->active()
            ->get();
    }

    /**
     * Create a new job opening with related data
     *
     * @param array $data
     * @return JobOpening
     */
    public function create(array $data): JobOpening
    {
        $job = parent::create($data);

        // Let the service handle the relationship syncing
        return $job;
    }

    /**
     * Search job titles based on query string
     *
     * @param string $query
     * @return Collection
     */
    public function searchTitles(string $query): Collection
    {
        return $this->model
            ->where('title', 'LIKE', "%{$query}%")
            ->select('title')
            ->distinct()
            ->limit(5)
            ->get();
    }

    /**
     * Filtered paginate method for job openings
     *
     * @param array $filters
     * @param string $searchQuery
     * @param array $searchColumns
     * @param string $sortColumn
     * @param string $sortDirection
     * @param array $sortableColumns
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function filteredPaginate(
        array $filters = [],
        string $searchQuery = '',
        array $searchColumns = [],
        string $sortColumn = 'created_at',
        string $sortDirection = 'desc',
        array $sortableColumns = [],
        int $perPage = 15
    ) {
        $query = $this->model->query();

        // Apply filters
        foreach ($filters as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'experience_min':
                        $query->where('experience_required', '>=', $value);
                        break;
                    case 'experience_max':
                        $query->where('experience_required', '<=', $value);
                        break;
                    case 'location':
                        $query->whereHas('locations', function ($q) use ($value) {
                            $q->where('locations.id', $value);
                        });
                        break;
                    case 'job_type':
                        $query->whereHas('jobTypes', function ($q) use ($value) {
                            $q->where('job_types.id', $value);
                        });
                        break;
                    case 'min_salary':
                        $query->where('min_salary', '>=', $value);
                        break;
                    case 'max_salary':
                        $query->where('max_salary', '<=', $value);
                        break;
                    case 'schedule':
                        $query->whereHas('schedules', function ($q) use ($value) {
                            $q->where('schedules.id', $value);
                        });
                        break;
                    default:
                        $query->where($key, $value);
                        break;
                }
            }
        }

        // Apply search
        if ($searchQuery && !empty($searchColumns)) {
            $query->where(function ($q) use ($searchQuery, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $q->orWhere($column, 'like', "%{$searchQuery}%");
                }
            });
        }

        // Apply sorting
        if (in_array($sortColumn, $sortableColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($perPage);
    }


    public function upcomingDeadlines()
    {
        return $this->model->upcomingDeadlines();
    }

    public function getUpcomingDeadlinesList($limit = 5)
    {
        return $this->model->upcomingDeadlines()
            ->orderBy('application_deadline')
            ->limit($limit)
            ->get();
    }

    public function getJobStatusDistribution()
    {
        return $this->model->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function countLastMonth()
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        return $this->model->where('created_at', '>=', $lastMonthStart)
            ->where('created_at', '<=', $lastMonthEnd)
            ->count();
    }

    public function countUpcomingDeadlinesLastMonth()
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        return $this->model->upcomingDeadlines()
            ->where('created_at', '>=', $lastMonthStart)
            ->where('created_at', '<=', $lastMonthEnd)
            ->count();
    }


    public function getDeadlinesBetween($start, $end)
    {
        return JobOpening::whereBetween('application_deadline', [
            Carbon::parse($start)->startOfDay(),
            Carbon::parse($end)->endOfDay()
        ])->get();
    }

    /**
     * Attach skills to a job opening
     *
     * @param int $jobOpeningId
     * @param array $skills
     * @return array Returns array of newly attached skill IDs
     */
    public function attachSkills(int $jobOpeningId, array $skills)
    {
        $jobOpening = $this->find($jobOpeningId);

        if (!$jobOpening) {
            throw new \Exception("Job opening not found");
        }

        // Get existing skill IDs to avoid duplicates
        $existingskills = $jobOpening->skills()->pluck('id')->toArray();

        // Filter out skills that are already attached
        $newskills = array_diff($skills, $existingskills);

        // Attach only new skills
        if (!empty($newskills)) {
            $jobOpening->skills()->attach($newskills);
        }

        return $newskills;
    }

    /**
     * Detach a skill from a job opening
     *
     * @param int $jobOpeningId
     * @param int $skillId
     * @return bool
     */
    public function detachSkill(int $jobOpeningId, int $skillId)
    {
        $jobOpening = $this->find($jobOpeningId);

        if (!$jobOpening) {
            throw new \Exception("Job opening not found");
        }

        $jobOpening->skills()->detach($skillId);

        return true;
    }

    /**
     * Get all skills associated with a job opening
     *
     * @param int $jobOpeningId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getJobOpeningSkills(int $jobOpeningId)
    {
        $jobOpening = $this->find($jobOpeningId);

        if (!$jobOpening) {
            throw new \Exception("Job opening not found");
        }

        return $jobOpening->skills()->get();
    }


    public function filterByStatus($status)
    {
        return $this->model->where('status', $status)->get();
    }

    // In JobApplicationRepository.php
    public function filterByJobIds(array $jobIds)
    {
        return $this->model->whereIn('job_id', $jobIds)->get();
    }

    public function getMonthlyApplications(array $jobIds = null)
    {
        $query = $this->model;

        if (!empty($jobIds)) {
            $query = $query->whereIn('job_id', $jobIds);
        }

        $result = $query->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Ensure all months are represented
        $months = range(1, 12);
        $applications = array_fill_keys($months, 0);

        foreach ($result as $month => $count) {
            $applications[$month] = $count;
        }

        return $applications;
    }



    public function getModel()
    {
        return $this->model;
    }
}
