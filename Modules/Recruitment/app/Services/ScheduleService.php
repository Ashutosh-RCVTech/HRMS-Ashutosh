<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\ScheduleRepository;

class ScheduleService
{
    protected $repository;

    public function __construct(ScheduleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllSchedules()
    {
        return $this->repository->all();
    }

    public function getAllSchedulesPaginated($perPage = 10, $search = null)
    {
        return $this->repository->paginate($perPage, $search);
    }

    public function createSchedule(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateSchedule(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    public function deleteSchedule($id)
    {
        return $this->repository->delete($id);
    }
}
