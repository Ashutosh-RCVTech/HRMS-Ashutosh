<?php

namespace Modules\Recruitment\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Recruitment\Repositories\Interfaces\College\BaseRepositoryInterface;

abstract class CollegeBaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    public function paginate($perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function with(array $relations): self
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function where($column, $operator, $value = null): self
    {
        $this->model = $this->model->where($column, $operator, $value);
        return $this;
    }

    public function whereIn($column, array $values): self
    {
        $this->model = $this->model->whereIn($column, $values);
        return $this;
    }

    public function orderBy($column, $direction = 'asc'): self
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    public function first(): ?Model
    {
        return $this->model->first();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function exists(): bool
    {
        return $this->model->exists();
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
