<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\CandidateRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CandidateService
{
    protected $repository;

    public function __construct(CandidateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCandidates(array $params = [])
    {
        $filters = $this->extractFilters($params);
        $searchQuery = $params['search'] ?? '';
        // $searchColumns = ['name', 'email', 'basic_detail.location'];
        $searchColumns = ['name', 'email'];
        $sortColumn = $params['sort_by'] ?? 'created_at';
        $sortDirection = $params['sort_direction'] ?? 'desc';
        $perPage = $params['per_page'] ?? 15;

        return $this->repository->filteredPaginate(
            $filters,
            $searchQuery,
            $searchColumns,
            $sortColumn,
            $sortDirection,
            [],
            $perPage
        );
    }

    public function getCandidate($id)
    {
        return $this->repository->find($id);
    }

    public function createCandidate(array $data)
    {
        // Generate password if not provided
        if (!isset($data['password'])) {
            $data['password'] = Str::random(10);
        }

        return $this->repository->create($data);
    }

    public function updateCandidate($id, array $data)
    {
        $this->validateCandidateData($data, true);

        // Handle file uploads
        if (isset($data['basic_detail']['resume'])) {
            $data['basic_detail']['resume_path'] = $this->uploadFile(
                $data['basic_detail']['resume'],
                'resumes'
            );
            unset($data['basic_detail']['resume']);
        }

        if (isset($data['basic_detail']['profile_image'])) {
            $data['basic_detail']['profile_image_path'] = $this->uploadFile(
                $data['basic_detail']['profile_image'],
                'profile-images'
            );
            unset($data['basic_detail']['profile_image']);
        }

        return $this->repository->update($data, $id);
    }

    public function deleteCandidate($id)
    {
        $candidate = $this->repository->find($id);

        // Delete associated files
        if ($candidate->basicDetail) {
            if ($candidate->basicDetail->resume_path) {
                Storage::delete($this->getStoragePath($candidate->basicDetail->resume_path));
            }
            if ($candidate->basicDetail->profile_image_path) {
                Storage::delete($this->getStoragePath($candidate->basicDetail->profile_image_path));
            }
        }

        return $this->repository->delete($id);
    }

    public function searchCandidates(string $query)
    {
        return $this->repository->search($query);
    }

    public function filterCandidates(array $filters)
    {
        return $this->repository->filter($filters)->get();
    }

    protected function validateCandidateData(array $data, bool $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => $isUpdate
                ? 'required|email|unique:candidate_users,email,' . ($data['id'] ?? '')
                : 'required|email|unique:candidate_users,email',
            'password' => $isUpdate ? 'nullable|min:6' : 'required|min:6',

            'basic_detail.name' => 'required|string|max:255',
            'basic_detail.location' => 'required|string|max:255',
            'basic_detail.mobile' => 'required|string|max:20',
            'basic_detail.resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'basic_detail.profile_image' => 'nullable|image|max:2048',
            'basic_detail.key_skills' => 'nullable|array',
            'basic_detail.it_skills' => 'nullable|array',

            'educations.*.degree' => 'required|string|max:255',
            'educations.*.institution' => 'required|string|max:255',
            'educations.*.year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'educations.*.grade' => 'nullable|string|max:50',

            'employments.*.company' => 'required|string|max:255',
            'employments.*.position' => 'required|string|max:255',
            'employments.*.start_date' => 'required|date',
            'employments.*.end_date' => 'nullable|date|after:employments.*.start_date',
            'employments.*.current' => 'boolean',
            'employments.*.description' => 'nullable|string',

            'career_profile.current_industry' => 'required|string|max:255',
            'career_profile.department' => 'required|string|max:255',
            'career_profile.desired_job_type' => 'required|string|max:255',
            'career_profile.desired_employment_type' => 'required|string|max:255',
            'career_profile.preferred_shift' => 'required|string|max:255',
            'career_profile.preferred_work_location' => 'required|string|max:255',
            'career_profile.expected_salary' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    protected function uploadFile($file, $directory)
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("public/$directory", $filename);
        return Storage::url($path);
    }

    protected function getStoragePath($url)
    {
        return str_replace('/storage/', 'public/', $url);
    }

    protected function extractFilters(array $params)
    {
        $filters = [];

        if (isset($params['location'])) {
            $filters['basic_detail.location'] = $params['location'];
        }

        if (isset($params['industry'])) {
            $filters['career_profile.current_industry'] = $params['industry'];
        }

        if (isset($params['job_type'])) {
            $filters['career_profile.desired_job_type'] = $params['job_type'];
        }

        if (isset($params['availability_from']) && isset($params['availability_to'])) {
            $filters['basic_detail.availability'] = [
                'from' => $params['availability_from'],
                'to' => $params['availability_to']
            ];
        }

        return $filters;
    }
}
