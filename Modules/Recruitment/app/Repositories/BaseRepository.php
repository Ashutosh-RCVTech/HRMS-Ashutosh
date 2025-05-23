<?php

namespace Modules\Recruitment\Repositories;

use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {

        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->delete();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function search(string $query, array $columns = ['*'])
    {
        return $this->model->where(function ($queryBuilder) use ($query, $columns) {
            foreach ($columns as $column) {
                $queryBuilder->orWhere($column, 'like', '%' . $query . '%');
            }
        })->get();
    }

    public function filter(array $filters)
    {
        $query = $this->model->query();

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                if (is_array($value) && isset($value['from']) && isset($value['to'])) {
                    $query->whereBetween($field, [$value['from'], $value['to']]);
                } else {
                    $query->where($field, '=', $value);
                }
            }
        }

        return $query;
    }

    public function sort(string $sortColumn, string $sortDirection, array $sortableColumns)
    {
        if (in_array($sortColumn, $sortableColumns)) {
            $sortDirection = strtolower($sortDirection) === 'desc' ? 'desc' : 'asc';
            return $this->model->orderBy($sortColumn, $sortDirection);
        }
        return $this->model;
    }

    public function paginate($perPage = 15)
    {
        return $this->model->paginate($perPage);
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

        // Apply search if a query is provided
        if ($searchQuery) {
            $query->where(function ($subQuery) use ($searchQuery, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $subQuery->orWhere($column, 'like', '%' . $searchQuery . '%');
                }
            });
        }

        // Apply sorting if a sort column is provided
        if ($sortColumn && in_array($sortColumn, $sortableColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Apply pagination
        return $query->paginate($perPage);
    }
}
