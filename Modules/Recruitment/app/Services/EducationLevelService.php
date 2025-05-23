<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\EducationLevelRepository;

class EducationLevelService
{
    protected $repository;

    public function __construct(EducationLevelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllEducationLevels()
    {
        return $this->repository->all();
    }

    public function getAllEducationLevelsPaginated($perPage = 10, $search = null)
    {
        return $this->repository->paginate($perPage, $search);
    }

    public function createEducationLevel(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateEducationLevel(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    public function deleteEducationLevel($id)
    {
        return $this->repository->delete($id);
    }

    public function searchEducationLevels(string $query, $page = 1)
    {
        // Use $query as an empty string if it's null
        if (is_null($query)) {
            $query = '';
        }
        return $this->repository->searchEducationLevels($query, $page);
    }
}
