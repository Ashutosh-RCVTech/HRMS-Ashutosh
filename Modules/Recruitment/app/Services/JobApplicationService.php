<?php

namespace Modules\Recruitment\Services;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Modules\Recruitment\Repositories\JobApplicationRepository;

class JobApplicationService
{
    protected $repository;

    public function __construct(JobApplicationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int $id)
    {
        $application = $this->repository->findById($id);
        if (!$application) {
            throw new Exception("Application not found.");
        }
        return $application;
    }

    public function getFilteredApplications(array $filters, int $perPage = 10)
    {
        return $this->repository->getFilteredApplications($filters, $perPage);
    }

    public function getFilterOptions()
    {
        return $this->repository->getFilterOptions();
    }


    public function getAvailableJobs()
    {
        return $this->repository->getAvailableJobs();
    }

    public function createApplication(array $data)
    {
        if (isset($data['resume'])) {
            try {
                $path = $data['resume']->store('resumes', 'public');
                $data['resume_path'] = $path;
            } catch (Exception $e) {
                throw new Exception('Failed to upload resume: ' . $e->getMessage());
            }
        }
        return $this->repository->create($data);
    }

    // public function updateApplicationStatus(int $id, string $status, ?string $feedback = null)
    // {
    //     $application = $this->repository->findById($id);
    //     if (!$application) {
    //         throw new Exception("Application not found.");
    //     }
    //     return $this->repository->update($id, ['status' => $status, 'feedback' => $feedback]);
    // }

    public function updateApplicationStatus(int $id, string $status, ?string $feedback = null)
    {
        $application = $this->findById($id);
        return $this->repository->update($id, ['status' => $status, 'feedback' => $feedback]);
    }

    public function downloadResume(int $id): BinaryFileResponse
    {
        // $application = $this->repository->findById($id);
        // if (!$application || !$application->resume_path) {
        //     throw new Exception("Resume not found.");
        // }

        $application = $this->findById($id);
        if (!$application->resume_path) {
            throw new Exception("Resume not found.");
        }

        $path = storage_path("app/public/{$application->resume_path}");
        if (!file_exists($path)) {
            throw new Exception("File does not exist on the server.");
        }

        return response()->download($path);
    }

    public function deleteApplication(int $id): bool
    {
        $application = $this->findById($id);
        if ($application->resume_path) {
            Storage::disk('public')->delete($application->resume_path);
        }
        return $this->repository->delete($id);
    }
}
