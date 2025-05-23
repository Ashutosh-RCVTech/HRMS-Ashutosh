<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\JobApplication;

class CandidateJobApplicationRepository extends BaseRepository implements CandidateJobApplicationRepositoryInterface
{
    public function __construct(JobApplication $model)
    {
        parent::__construct($model);
    }

    public function getByCandidate($candidateId)
    {
        return $this->model->where('candidate_id', $candidateId)
            ->with(['job'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getStatusCounts($candidateId)
    {
        $applications = $this->model->where('candidate_id', $candidateId)->get();

        $counts = [
            'total' => $applications->count(),
            'pending' => $applications->where('status', 'pending')->count(),
            'screening' => $applications->where('status', 'screening')->count(),
            'interview' => $applications->where('status', 'interview')->count(),
            'offered' => $applications->where('status', 'offered')->count(),
            'rejected' => $applications->where('status', 'rejected')->count(),
            'closed' => $applications->where('status', 'closed')->count(),
        ];

        return $counts;
    }

    public function findWithRelations($id)
    {
        return $this->model->with(['job'])->findOrFail($id);
    }

    public function createApplication(array $data)
    {
        // Handle file upload if resume is included
        if (isset($data['resume']) && $data['resume']) {
            $data['resume_path'] = $data['resume']->store('resumes', 'public');
        }

        return $this->create($data);
    }

    public function updateApplicationStatus($id, $status)
    {
        return $this->update(['status' => $status], $id);
    }

    public function filteredPaginate(
        array $filters = [],
        string $searchQuery = '',
        array $searchColumns = ['*'],
        string $sortColumn = 'created_at',
        string $sortDirection = 'desc',
        array $sortableColumns = [],
        int $perPage = 15
    ) {
        $query = $this->filter($filters);

        // Always filter by the authenticated candidate
        $candidateId = auth()->guard('candidate')->id();
        $query->where('candidate_id', $candidateId);

        // Add job relationship to query
        $query->with('job');

        // Apply search if a query is provided
        if ($searchQuery) {
            $query->whereHas('job', function ($subQuery) use ($searchQuery) {
                $subQuery->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%')
                    ->orWhere('client', 'like', '%' . $searchQuery . '%')
                    // ->orWhere('locations', 'like', '%' . $searchQuery . '%')
                ;
            });
        }

        // Apply sorting if a sort column is provided
        if ($sortColumn) {
            if (in_array($sortColumn, ['job_title', 'client'])) {
                $query->join('job_openings', 'job_applications.job_id', '=', 'job_openings.id')
                    ->select('job_applications.*');

                if ($sortColumn === 'job_title') {
                    $query->orderBy('job_openings.title', $sortDirection);
                } else if ($sortColumn === 'client') {
                    $query->orderBy('job_openings.client', $sortDirection);
                }
            } else {
                $query->orderBy($sortColumn, $sortDirection);
            }
        }

        // Apply pagination
        return $query->paginate($perPage);
    }
}
