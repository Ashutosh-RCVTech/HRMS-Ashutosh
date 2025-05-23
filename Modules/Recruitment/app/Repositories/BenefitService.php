<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\BenefitRepository;

class BenefitService
{
    protected $repository;

    public function __construct(BenefitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllBenefits()
    {
        return $this->repository->all();
    }

    public function getAllBenefitsPaginated($perPage = 10, $search = null)
    {
        return $this->repository->paginate($perPage, $search);
    }

    public function createBenefit(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateBenefit(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    public function deleteBenefit($id)
    {
        return $this->repository->delete($id);
    }
}
