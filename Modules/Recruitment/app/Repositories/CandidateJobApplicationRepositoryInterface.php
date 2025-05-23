<?php

namespace Modules\Recruitment\Repositories;

interface CandidateJobApplicationRepositoryInterface extends BaseRepositoryInterface
{
    public function getByCandidate($candidateId);
    public function getStatusCounts($candidateId);
    public function findWithRelations($id);
    public function createApplication(array $data);
    public function updateApplicationStatus($id, $status);
}
