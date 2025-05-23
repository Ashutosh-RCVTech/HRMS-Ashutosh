<?php

namespace Modules\Recruitment\Repositories;

interface BaseRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id);
    public function search(string $query, array $columns = ['*']);
    public function filter(array $filters);
    public function sort(string $sortColumn, string $sortDirection, array $sortableColumns);
    public function paginate($perPage = 15);
    public function filteredPaginate(
        array $filters = [],
        string $searchQuery = '',
        array $searchColumns = ['*'],
        string $sortColumn = '',
        string $sortDirection = 'asc',
        array $sortableColumns = [],
        int $perPage = 15
    );
}
