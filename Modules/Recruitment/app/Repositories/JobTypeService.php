<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\JobTypeRepository;

class JobTypeService
{
    protected $jobTypeRepository;

    public function __construct(JobTypeRepository $jobTypeRepository)
    {
        $this->jobTypeRepository = $jobTypeRepository;
    }

    public function getAllJobTypes()
    {
        return $this->jobTypeRepository->all();
    }

    public function getAllJobTypesPaginated($perPage = 10)
    {
        return $this->jobTypeRepository->paginate($perPage);
    }

    public function createJobType(array $data)
    {
        return $this->jobTypeRepository->create($data);
    }

    public function updateJobType(array $data, $id)
    {
        return $this->jobTypeRepository->update($data, $id);
    }

    public function deleteJobType($id)
    {
        return $this->jobTypeRepository->delete($id);
    }
}
