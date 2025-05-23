<?php

namespace Modules\Recruitment\Repositories\Interfaces\College;

interface BaseRepositoryInterface
{
    public function all();
    public function find($id);
    public function findOrFail($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function paginate($perPage = 15);
    public function with(array $relations);
    public function where($column, $operator, $value = null);
    public function whereIn($column, array $values);
    public function orderBy($column, $direction = 'asc');
    public function first();
    public function count();
    public function exists();
}
