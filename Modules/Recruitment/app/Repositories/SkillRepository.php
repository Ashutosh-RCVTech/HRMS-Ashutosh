<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\Skill;

class SkillRepository extends BaseRepository
{
    public function __construct(Skill $model)
    {
        parent::__construct($model);
    }

    public function paginate($perPage = 10, $search = null)
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        return $query->orderBy('name')->paginate($perPage);
    }

    public function searchByName(string $query, int $jobOpeningId)
    {
        return $this->model
            ->where('name', 'LIKE', "%{$query}%")
            ->whereNotIn('id', function ($subquery) use ($jobOpeningId) {
                $subquery->select('skill_id')
                    ->from('job_opening_skills')
                    ->where('job_opening_id', $jobOpeningId);
            })
            ->get(['id', 'name']);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function getSkillsInCategory($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->get();
    }

    /**
     * Get paginated results with filtering, searching, and sorting options
     * 
     * @param array $filters Associative array of filter conditions
     * @param string $searchQuery Search query string
     * @param array $searchColumns Columns to search in
     * @param string $sortColumn Column to sort by
     * @param string $sortDirection Sort direction (asc/desc)
     * @param array $sortableColumns Allowed columns for sorting
     * @param int $perPage Number of items per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filteredPaginate(
        array $filters = [],
        string $searchQuery = '',
        array $searchColumns = ['name'],
        string $sortColumn = 'name',
        string $sortDirection = 'asc',
        array $sortableColumns = ['name', 'created_at', 'category_id'],
        int $perPage = 15
    ) {
        $query = $this->model->query();

        // Apply filters
        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                if (is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }

        // Apply search if query is provided
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$searchQuery}%");
                }
            });
        }

        // Apply sorting
        if (in_array($sortColumn, $sortableColumns)) {
            $query->orderBy($sortColumn, strtolower($sortDirection) === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('name', 'asc');
        }

        return $query->paginate($perPage);
    }
}
