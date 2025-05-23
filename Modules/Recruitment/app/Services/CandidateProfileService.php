<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\CandidateEducation;
use Modules\Recruitment\Models\CandidateEmployment;
use Modules\Recruitment\Models\CandidateBasicDetail;
use Modules\Recruitment\Models\CandidateCareerProfile;
use Modules\Recruitment\Services\Interfaces\ICandidateProfileService;

class CandidateProfileService implements ICandidateProfileService
{
    protected $basicDetailModel;
    protected $educationModel;
    protected $employmentModel;
    protected $careerProfileModel;

    public function __construct(
        CandidateBasicDetail $basicDetailModel,
        CandidateEducation $educationModel,
        CandidateEmployment $employmentModel,
        CandidateCareerProfile $careerProfileModel
    ) {
        $this->basicDetailModel = $basicDetailModel;
        $this->educationModel = $educationModel;
        $this->employmentModel = $employmentModel;
        $this->careerProfileModel = $careerProfileModel;
    }

    public function getCandidateProfile(int $candidateId): array
    {
        $candidate = CandidateUser::findOrFail($candidateId);
        $basicDetail = $this->basicDetailModel->firstOrNew(['candidate_id' => $candidateId]);
        $educations = $this->educationModel->where('candidate_id', $candidateId)->get();
        $employments = $this->employmentModel->where('candidate_id', $candidateId)->get();
        $careerProfile = $this->careerProfileModel->firstOrNew(['candidate_id' => $candidateId]);

        return compact('candidate', 'basicDetail', 'educations', 'employments', 'careerProfile');
    }

    public function updateBasicDetails(int $candidateId, array $data)
    {
        return $this->basicDetailModel->updateOrCreate(
            ['candidate_id' => $candidateId],
            $data
        );
    }

    public function updateEducation(int $candidateId, array $educations)
    {

 
        $existingIds = [];

        foreach ($educations as $educationData) {
            $education = $this->educationModel->updateOrCreate(
                [
                    'id' => $educationData['id'] ?? null,
                    'candidate_id' => $candidateId
                ],
                $educationData
            );
            $existingIds[] = $education->id;
        }

        
        // Delete removed educations
        $this->educationModel->where('candidate_id', $candidateId)
            ->whereNotIn('id', $existingIds)
            ->delete();

        return $this->educationModel->where('candidate_id', $candidateId)->get();
    }

    public function updateEmployment(int $candidateId, array $employments)
    {
        $existingIds = [];

        foreach ($employments as $employmentData) {
            $employment = $this->employmentModel->updateOrCreate(
                [
                    'id' => $employmentData['id'] ?? null,
                    'candidate_id' => $candidateId
                ],
                $employmentData
            );
            $existingIds[] = $employment->id;
        }

        // Delete removed employments
        $this->employmentModel->where('candidate_id', $candidateId)
            ->whereNotIn('id', $existingIds)
            ->delete();

        return $this->employmentModel->where('candidate_id', $candidateId)->get();
    }

    public function updateCareerProfile(int $candidateId, array $data)
    {
        return $this->careerProfileModel->updateOrCreate(
            ['candidate_id' => $candidateId],
            $data
        );
    }
}
