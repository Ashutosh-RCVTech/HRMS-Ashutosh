<?php

namespace Modules\Recruitment\Repositories;

use Carbon\Carbon;
use Modules\Recruitment\Models\JobApplication;
use Illuminate\Pagination\LengthAwarePaginator;

class JobApplicationRepository
{
    protected $model;

    public function __construct(JobApplication $model)
    {
        $this->model = $model;
    }

    public function getFilteredApplications(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['candidate', 'job'])
            ->join('job_openings', 'job_applications.job_id', '=', 'job_openings.id')
            ->join('candidate_users', 'job_applications.candidate_id', '=', 'candidate_users.id');

        // Add location join if needed
        if (!empty($filters['location'])) {
            $query->join('job_opening_locations', 'job_openings.id', '=', 'job_opening_locations.job_opening_id')
                ->join('locations', 'job_opening_locations.location_id', '=', 'locations.id');
        }
        $query->select(
            'job_applications.*',
            'job_openings.title as job_title',
            'job_openings.client',
            'job_openings.experience_required',
            'job_openings.location_type',
            'job_openings.min_salary',
            'job_openings.max_salary',
            'job_openings.education_level',
            'job_openings.degree',
            'job_openings.status as job_status'
        );


        // Location filter
        if (!empty($filters['location'])) {
            $query->where('locations.id', $filters['location']);
        }

        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('job_openings.title', 'like', $searchTerm)
                    ->orWhere('candidate_users.name', 'like', $searchTerm)
                    ->orWhere('job_openings.client', 'like', $searchTerm);
            });
        }

        if (!empty($filters['experience'])) {
            $query->where('job_openings.experience_required', $filters['experience']);
        }

        if (!empty($filters['location_type'])) {
            $query->where('job_openings.location_type', $filters['location_type']);
        }

        if (!empty($filters['education_level'])) {
            $query->where('job_openings.education_level', $filters['education_level']);
        }

        if (!empty($filters['min_salary'])) {
            $query->where('job_openings.min_salary', '>=', $filters['min_salary']);
        }

        if (!empty($filters['max_salary'])) {
            $query->where('job_openings.max_salary', '<=', $filters['max_salary']);
        }

        if (!empty($filters['job_status'])) {
            $query->where('job_openings.status', $filters['job_status']);
        }

        if (!empty($filters['sort_field'])) {
            $validSortFields = ['job_applications.created_at', 'job_openings.title'];
            if (in_array($filters['sort_field'], $validSortFields)) {
                $direction = $filters['sort_direction'] === 'asc' ? 'asc' : 'desc';
                $query->orderBy($filters['sort_field'], $direction);
            }
        } else {
            $query->latest();
        }

        return $query->paginate($perPage);
    }

    public function getFilterOptions(): array
    {
        return [
            'experience_levels' => $this->model
                ->join('job_openings', 'job_applications.job_id', '=', 'job_openings.id')
                ->distinct()
                ->pluck('job_openings.experience_required')
                ->toArray(),

            'location_types' => $this->model
                ->join('job_openings', 'job_applications.job_id', '=', 'job_openings.id')
                ->distinct()
                ->pluck('job_openings.location_type')
                ->toArray(),

            'education_levels' => $this->model
                ->join('job_openings', 'job_applications.job_id', '=', 'job_openings.id')
                ->distinct()
                ->pluck('job_openings.education_level')
                ->toArray(),

            'locations' => $this->model
                ->join('job_openings', 'job_applications.job_id', '=', 'job_openings.id')
                ->join('job_opening_locations', 'job_openings.id', '=', 'job_opening_locations.job_opening_id')
                ->join('locations', 'job_opening_locations.location_id', '=', 'locations.id')
                ->distinct()
                ->pluck('locations.name', 'locations.id')
                ->toArray()
        ];
    }


    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $application = $this->findById($id);
        return $application ? tap($application)->update($data) : null;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getAvailableJobs()
    {
        return \Modules\Recruitment\Models\JobOpening::where('status', 'open')->get();
    }

    public function activeApplications()
    {
        return $this->model->active();
    }

    public function getRecentApplications($limit = 10)
    {
        return $this->model->with(['candidate', 'job'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getMonthlyApplications()
    {
        $data = $this->model->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        return array_replace(
            array_fill_keys(range(1, 12), 0),
            $data->toArray()
        );
    }

    public function countActiveLastMonth()
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        return $this->model->active()
            ->where('created_at', '>=', $lastMonthStart)
            ->where('created_at', '<=', $lastMonthEnd)
            ->count();
    }

    public function filterByJobIds(array $jobIds)
    {
        return $this->model->whereIn('job_id', $jobIds)->get();
    }

    public function getApplicationTrends($timeframe)
    {
        $query = $this->model->selectRaw(
            match ($timeframe) {
                'daily' => 'DATE(created_at) as date, COUNT(*) as count',
                'weekly' => 'WEEK(created_at, 3) as week, COUNT(*) as count',
                'monthly' => 'DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count',
            }
        )
            ->groupBy(match ($timeframe) {
                'daily' => 'date',
                'weekly' => 'week',
                'monthly' => 'month',
            })
            ->orderBy(match ($timeframe) {
                'daily' => 'date',
                'weekly' => 'week',
                'monthly' => 'month',
            });

        // For daily trends, get last 7 days
        if ($timeframe === 'daily') {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        return $query->pluck('count', match ($timeframe) {
            'daily' => 'date',
            'weekly' => 'week',
            'monthly' => 'month',
        })->toArray();
    }
}
