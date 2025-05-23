<?php

namespace Modules\Recruitment\Services;

use Illuminate\Support\Str;
use Modules\Recruitment\Models\Skill;
use Modules\Recruitment\Repositories\SkillRepository;
use Modules\Recruitment\Repositories\JobOpeningRepository;

class SkillService
{
    protected $skillRepository;
    protected $jobOpeningRepository;

    public function __construct(SkillRepository $skillRepository, JobOpeningRepository $jobOpeningRepository)
    {
        $this->skillRepository = $skillRepository;
        $this->jobOpeningRepository = $jobOpeningRepository;
    }

    public function getAllSkills()
    {
        return $this->skillRepository->all();
    }

    public function getAllSkillsPaginated($perPage = 10, $search = null)
    {
        return $this->skillRepository->paginate($perPage, $search);
    }

    public function createSkill(array $data)
    {
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->skillRepository->create($data);
    }

    public function updateSkill(array $data, $id)
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->skillRepository->update($data, $id);
    }

    public function deleteSkill($id)
    {
        return $this->skillRepository->delete($id);
    }

    public function findSkill($id)
    {
        return $this->skillRepository->find($id);
    }

    public function searchSkills(string $query, int $jobOpeningId)
    {
        return $this->skillRepository->searchByName($query, $jobOpeningId);
    }

    public function addSkills(int $jobOpeningId, array $skills)
    {
        return $this->jobOpeningRepository->attachSkills($jobOpeningId, $skills);
    }

    public function removeSkill(int $jobOpeningId, int $skillId)
    {
        return $this->jobOpeningRepository->detachSkill($jobOpeningId, $skillId);
    }

    public function getJobOpeningSkills(int $jobOpeningId)
    {
        return $this->jobOpeningRepository->getJobOpeningSkills($jobOpeningId);
    }

    public function searchSkillsWithFilters(
        array $filters = [],
        string $searchQuery = '',
        array $searchColumns = ['name'],
        string $sortColumn = 'name',
        string $sortDirection = 'asc',
        array $sortableColumns = ['name', 'created_at', 'category_id'],
        int $perPage = 15
    ) {
        return $this->skillRepository->filteredPaginate(
            $filters,
            $searchQuery,
            $searchColumns,
            $sortColumn,
            $sortDirection,
            $sortableColumns,
            $perPage
        );
    }
}
