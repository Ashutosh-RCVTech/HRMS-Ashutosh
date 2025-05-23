<?php

namespace Modules\Recruitment\Services\Interfaces;

interface ICandidateProfileService
{
    public function getCandidateProfile(int $candidateId): array;
    public function updateBasicDetails(int $candidateId, array $data);
    public function updateEducation(int $candidateId, array $educations);
    public function updateEmployment(int $candidateId, array $employments);
    public function updateCareerProfile(int $candidateId, array $data);
}
