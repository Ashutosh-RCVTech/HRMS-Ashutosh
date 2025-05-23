<?php

namespace Modules\Recruitment\Repositories;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Recruitment\Models\CandidateUser;

class CandidateRepository extends BaseRepository
{
    public function __construct(CandidateUser $model)
    {
        parent::__construct($model);
    }

    protected $searchableColumns = [
        'name',
        'email'
    ];

    protected $sortableColumns = [
        'name',
        'email',
        'created_at',
        'updated_at'
    ];

    protected $filterableColumns = [
        'name',
        'email',
        'created_at',
        'basic_detail.location',
        'basic_detail.availability',
        'career_profile.current_industry',
        'career_profile.desired_job_type'
    ];



    public function all()
    {
        return $this->model->with(['basicDetail'])->get();
    }

    public function find($id)
    {
        return $this->model->with([
            'basicDetail',
            'educations',
            'employments',
            'careerProfile'
        ])->findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            // Hash password
            $data['password'] = Hash::make($data['password']);

            // Create candidate
            $candidate = parent::create($data);

            // Handle relationships
            $this->handleRelationships($candidate, $data);

            DB::commit();
            return $candidate->fresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function handleRelationships($candidate, $data)
    {
        // Basic Detail
        if (isset($data['basic_detail'])) {
            $candidate->basicDetail()->create($data['basic_detail']);
        }

        // Educations
        if (isset($data['educations']) && is_array($data['educations'])) {
            $candidate->educations()->createMany($data['educations']);
        }

        // Employments
        if (isset($data['employments']) && is_array($data['employments'])) {
            $candidate->employments()->createMany($data['employments']);
        }

        // Career Profile
        if (isset($data['career_profile'])) {
            $candidate->careerProfile()->create($data['career_profile']);
        }
    }

    public function update(array $data, $id)
    {
        DB::beginTransaction();
        try {
            $candidate = $this->model->findOrFail($id);

            // Update password if provided
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            // Update main candidate data
            $candidate->update($data);

            // Update related data if provided
            if (isset($data['basic_detail'])) {
                $candidate->basicDetail()->updateOrCreate(
                    ['candidate_id' => $id],
                    $data['basic_detail']
                );
            }

            if (isset($data['educations'])) {
                $candidate->educations()->delete();
                $candidate->educations()->createMany($data['educations']);
            }

            if (isset($data['employments'])) {
                $candidate->employments()->delete();
                $candidate->employments()->createMany($data['employments']);
            }

            if (isset($data['career_profile'])) {
                $candidate->careerProfile()->updateOrCreate(
                    ['candidate_id' => $id],
                    $data['career_profile']
                );
            }

            DB::commit();
            return $candidate->fresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $candidate = $this->model->findOrFail($id);

            // Delete related records
            $candidate->basicDetail()->delete();
            $candidate->educations()->delete();
            $candidate->employments()->delete();
            $candidate->careerProfile()->delete();

            $result = $candidate->delete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function search(string $query, array $columns = ['*'])
    {
        $query = $this->model->with(['basicDetail']);

        return $query->where(function ($queryBuilder) use ($query, $columns) {
            foreach ($columns as $column) {
                if ($column === '*') {
                    foreach ($this->searchableColumns as $searchableColumn) {
                        $queryBuilder->orWhere($searchableColumn, 'like', '%' . $query . '%');
                    }
                } else {
                    $queryBuilder->orWhere($column, 'like', '%' . $query . '%');
                }
            }
        })->get();
    }

    public function filter(array $filters)
    {
        $query = $this->model->with(['basicDetail']);

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                if (str_contains($field, '.')) {
                    // Handle related model filters
                    [$relation, $column] = explode('.', $field);
                    $query->whereHas($relation, function ($q) use ($column, $value) {
                        if (is_array($value) && isset($value['from']) && isset($value['to'])) {
                            $q->whereBetween($column, [$value['from'], $value['to']]);
                        } else {
                            $q->where($column, '=', $value);
                        }
                    });
                } else {
                    // Handle direct model filters
                    if (is_array($value) && isset($value['from']) && isset($value['to'])) {
                        $query->whereBetween($field, [$value['from'], $value['to']]);
                    } else {
                        $query->where($field, '=', $value);
                    }
                }
            }
        }

        return $query;
    }

    public function sort(string $sortColumn, string $sortDirection, array $sortableColumns = [])
    {
        $sortableColumns = !empty($sortableColumns) ? $sortableColumns : $this->sortableColumns;
        return parent::sort($sortColumn, $sortDirection, $sortableColumns);
    }

    public function filteredPaginate(
        array $filters = [],
        string $searchQuery = '',
        array $searchColumns = ['*'],
        string $sortColumn = '',
        string $sortDirection = 'asc',
        array $sortableColumns = [],
        int $perPage = 15
    ) {
        $query = $this->filter($filters);
        // Apply search if query provided
        if ($searchQuery) {
            $query->where(function ($subQuery) use ($searchQuery, $searchColumns) {
                foreach ($searchColumns as $column) {
                    if ($column === '*') {
                        foreach ($this->searchableColumns as $searchableColumn) {
                            $subQuery->orWhere($searchableColumn, 'like', '%' . $searchQuery . '%');
                        }
                    } else {
                        $subQuery->orWhere($column, 'like', '%' . $searchQuery . '%');
                    }
                }
            });
        }

        // Apply sorting
        $sortableColumns = !empty($sortableColumns) ? $sortableColumns : $this->sortableColumns;
        if ($sortColumn && in_array($sortColumn, $sortableColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Load relationships
        $query->with(['basicDetail']);
        return $query->paginate($perPage);
    }

    // Custom methods for specific candidate functionality
    public function searchBySkills(array $skills)
    {
        return $this->model->whereHas('basicDetail', function ($query) use ($skills) {
            foreach ($skills as $skill) {
                $query->whereJsonContains('key_skills', $skill);
            }
        })->get();
    }

    public function getByExperience($minYears, $maxYears = null)
    {
        $query = $this->model->whereHas('employments', function ($query) use ($minYears, $maxYears) {
            $query->selectRaw('SUM(DATEDIFF(COALESCE(end_date, CURRENT_DATE), start_date)/365) as total_experience')
                ->havingRaw('total_experience >= ?', [$minYears]);

            if ($maxYears) {
                $query->havingRaw('total_experience <= ?', [$maxYears]);
            }
        });

        return $query;
    }

    public function newCandidates()
    {
        return $this->model->newCandidates();
    }

    public function countNewCandidatesLastMonth()
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        return $this->model->newCandidates()
            ->where('created_at', '>=', $lastMonthStart)
            ->where('created_at', '<=', $lastMonthEnd)
            ->count();
    }
}
