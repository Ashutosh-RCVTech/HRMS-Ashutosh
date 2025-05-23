<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Repositories\CandidateJobApplicationRepositoryInterface;

class CandidateJobApplicationService
{
    protected $jobApplicationRepository;

    public function __construct(CandidateJobApplicationRepositoryInterface $jobApplicationRepository)
    {
        $this->jobApplicationRepository = $jobApplicationRepository;
    }

    public function getCandidateApplications($candidateId)
    {
        return $this->jobApplicationRepository->getByCandidate($candidateId);
    }

    public function getStatusCounts($candidateId)
    {
        return $this->jobApplicationRepository->getStatusCounts($candidateId);
    }

    public function getApplicationDetails($id)
    {
        return $this->jobApplicationRepository->findWithRelations($id);
    }

    public function createApplication(array $data)
    {
        return $this->jobApplicationRepository->createApplication($data);
    }

    public function withdrawApplication($id)
    {
        return $this->jobApplicationRepository->updateApplicationStatus($id, 'withdrawn');
    }

    public function searchAndFilterApplications(
        array $filters = [],
        ?string $searchQuery = null, // Make $searchQuery nullable
        string $sortColumn = 'created_at',
        string $sortDirection = 'desc',
        int $perPage = 10
    ) {
        $searchQuery = $searchQuery ?? ''; // Convert null to empty string
        $searchColumns = ['*'];
        $sortableColumns = ['created_at', 'status', 'job_title', 'client'];

        return $this->jobApplicationRepository->filteredPaginate(
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
