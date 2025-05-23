<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\DegreeRepository;

class DegreeService
{
    protected $repository;

    public function __construct(DegreeRepository $repository)
    {

        $this->repository = $repository;
    }

    public function getAllDegreesPaginated($perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function getAllDegrees()
    {
        return $this->repository->all();
    }
    public function createDegree(array $data)
    {
        return $this->repository->create($data);
    }
    public function updateDegree(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    public function deleteDegree($id)
    {
        return $this->repository->delete($id);
    }
}
