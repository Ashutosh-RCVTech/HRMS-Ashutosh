<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\LocationRepository;

class LocationService
{
    protected $repository;

    public function __construct(LocationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllLocations()
    {
        return $this->repository->all();
    }

    public function getAllLocationsPaginated($perPage = 10, $search = null)
    {
        return $this->repository->paginate($perPage, $search);
    }

    public function createLocation(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateLocation(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    public function deleteLocation($id)
    {
        return $this->repository->delete($id);
    }
}
