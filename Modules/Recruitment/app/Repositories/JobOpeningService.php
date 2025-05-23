<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Models\JobOpening;
use Modules\Recruitment\Repositories\JobOpeningRepository;


// class JobOpeningService
// {
//     public function __construct(
//         protected JobOpeningRepository $jobOpeningRepository
//     ) {}

//     public function getFilterOptions()
//     {
//         return [
//             'locations' => \Modules\Recruitment\Models\Location::all(),
//             'jobTypes' => \Modules\Recruitment\Models\JobType::all(),
//             'schedules' => \Modules\Recruitment\Models\Schedule::all()
//         ];
//     }

//     public function listJobOpenings(
//         array $filters = [],
//         string $searchQuery = '',
//         string $sortColumn = 'created_at',
//         string $sortDirection = 'desc',
//         int $perPage = 15
//     ) {
//         $query = JobOpening::query();

//         // Handle experience filters first
//         $experienceMin = $filters['experience_min'] ?? null;
//         $experienceMax = $filters['experience_max'] ?? null;

//         if ($experienceMin !== null || $experienceMax !== null) {
//             if ($experienceMin !== null) {
//                 $query->where('experience_required', '>=', $experienceMin);
//             }
//             if ($experienceMax !== null) {
//                 $query->where('experience_required', '<=', $experienceMax);
//             }
//             // Remove from filters to prevent duplication
//             unset($filters['experience_min']);
//             unset($filters['experience_max']);
//         }

//         foreach ($filters as $key => $value) {
//             switch ($key) {
//                 case 'location':
//                     $query->whereHas('locations', function ($q) use ($value) {
//                         $q->where('locations.id', $value);
//                     });
//                     break;
//                     // Add cases for other filters like 'job_type', 'schedule', etc.
//                 default:
//                     $query->where($key, $value);
//                     break;
//             }
//         }

//         // Handle search
//         if ($searchQuery) {
//             $query->where(function ($q) use ($searchQuery) {
//                 $q->where('title', 'like', "%{$searchQuery}%")
//                     ->orWhere('description', 'like', "%{$searchQuery}%")
//                     ->orWhere('experience_required', 'like', "%{$searchQuery}%");
//             });
//         }

//         // Sorting
//         $query->orderBy($sortColumn, $sortDirection);

//         return $query->paginate($perPage);
//     }

//     public function createJobOpening(array $data)
//     {
//         $jobOpening = $this->jobOpeningRepository->create($data);

//         $this->syncJobRelations($jobOpening, $data);

//         return $jobOpening;
//     }

//     public function updateJobOpening(array $data, $id)
//     {
//         $jobOpening = $this->jobOpeningRepository->update($data, $id);

//         $this->syncJobRelations($jobOpening, $data);

//         return $jobOpening;
//     }

//     public function getJobOpeningById($id)
//     {
//         return $this->jobOpeningRepository->find($id);
//     }

//     public function deleteJobOpening($id)
//     {
//         return $this->jobOpeningRepository->delete($id);
//     }

//     /**
//      * Sync job relationships.
//      */
//     private function syncJobRelations($jobOpening, array $data)
//     {
//         $relations = [
//             'skills' => 'skills',
//             'job_types' => 'jobTypes',
//             'schedules' => 'schedules',
//             'benefits' => 'benefits',
//             'selected_locations' => 'locations'
//         ];

//         foreach ($relations as $key => $relation) {
//             if (!empty($data[$key])) {
//                 $jobOpening->{$relation}()->sync(array_values(array_filter($data[$key])));
//             }
//         }
//     }

//     public function searchJobTitles(string $query)
//     {
//         return $this->jobOpeningRepository->searchTitles($query);
//     }
// }




class JobOpeningService
{
    /**
     * @var JobOpeningRepository
     */
    protected JobOpeningRepository $jobOpeningRepository;

    /**
     * @param JobOpeningRepository $jobOpeningRepository
     */
    public function __construct(JobOpeningRepository $jobOpeningRepository)
    {
        $this->jobOpeningRepository = $jobOpeningRepository;
    }

    /**
     * Get filter options for job listings
     *
     * @return array
     */
    public function getFilterOptions(): array
    {
        return [
            'locations' => \Modules\Recruitment\Models\Location::all(),
            'jobTypes' => \Modules\Recruitment\Models\JobType::all(),
            'schedules' => \Modules\Recruitment\Models\Schedule::all(),
            'experienceRanges' => \Modules\Recruitment\Models\JobOpening::getExperienceRanges()
        ];
    }

    /**
     * List job openings with filters, search and pagination
     *
     * @param array $filters
     * @param string $searchQuery
     * @param string $sortColumn
     * @param string $sortDirection
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function listJobOpenings(
        array $filters = [],
        string $searchQuery = '',
        string $sortColumn = 'created_at',
        string $sortDirection = 'desc',
        int $perPage = 15
    ) {
        $query = $this->jobOpeningRepository->getModel()->newQuery();

        // Handle experience filter
        if (isset($filters['experience_required']) && !empty($filters['experience_required'])) {
            $experienceRange = $filters['experience_required'];
            if ($experienceRange === '10+') {
                $query->where('experience_required', '>=', '10');
            } else {
                $query->where('experience_required', $experienceRange);
            }
        }

        // Handle other filters
        foreach ($filters as $key => $value) {
            if ($key !== 'experience_required' && !empty($value)) {
                $query->where($key, $value);
            }
        }

        // Handle search
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('description', 'like', "%{$searchQuery}%");
            });
        }

        // Handle sorting
        $query->orderBy($sortColumn, $sortDirection);

        return $query->paginate($perPage);
    }

    /**
     * Create a new job opening
     *
     * @param array $data
     * @return JobOpening
     */
    public function createJobOpening(array $data): JobOpening
    {
        $jobOpening = $this->jobOpeningRepository->create($data);
        $this->syncJobRelations($jobOpening, $data);
        return $jobOpening;
    }

    /**
     * Update an existing job opening
     *
     * @param array $data
     * @param int $id
     * @return JobOpening
     */
    public function updateJobOpening(array $data, $id): JobOpening
    {
        $jobOpening = $this->jobOpeningRepository->update($data, $id);
        // Sync skills explicitly
        if (isset($data['skills']) && !empty($data['skills'])) {
            $jobOpening->skills()->sync($data['skills']);
        }

        $this->syncJobRelations($jobOpening, $data);
        return $jobOpening;
    }

    /**
     * Get job opening by ID
     *
     * @param int $id
     * @return JobOpening|null
     */
    public function getJobOpeningById($id): ?JobOpening
    {
        return $this->jobOpeningRepository->find($id);
    }

    /**
     * Delete a job opening
     *
     * @param int $id
     * @return bool
     */
    public function deleteJobOpening($id): bool
    {
        return $this->jobOpeningRepository->delete($id);
    }

    /**
     * Sync job relationships
     *
     * @param JobOpening $jobOpening
     * @param array $data
     * @return void
     */
    // private function syncJobRelations(JobOpening $jobOpening, array $data): void
    // {
    //     $relations = [
    //         'skills' => 'skills',
    //         'job_types' => 'jobTypes',
    //         'schedules' => 'schedules',
    //         'benefits' => 'benefits',
    //         'selected_locations' => 'locations'
    //     ];

    //     foreach ($relations as $key => $relation) {
    //         if (isset($data[$key]) && is_array($data[$key])) {
    //             $relationData = array_values(array_filter($data[$key], fn($value) => !is_null($value)));
    //             if (!empty($relationData)) {
    //                 $jobOpening->{$relation}()->sync($relationData);
    //             }
    //         }
    //     }
    // }

    /**
 * Sync job relationships
 *
 * @param JobOpening $jobOpening
 * @param array $data
 * @return void
 */
    private function syncJobRelations(JobOpening $jobOpening, array $data): void
    {
        $relations = [
            'skills' => 'skills',
            'selected_job_types' => 'jobTypes',
            'selected_schedules' => 'schedules',
            'selected_benefits' => 'benefits',
            'selected_locations' => 'locations'
        ];

        foreach ($relations as $key => $relation) {
            if (isset($data[$key]) && is_array($data[$key])) {
                // Filter out null and empty string values
                $relationData = array_values(array_filter($data[$key], function ($value) {
                    return $value !== null && $value !== '';
                }));

                if (!empty($relationData)) {
                    $jobOpening->{$relation}()->sync($relationData);
                }
            }
        }
    }

    /**
     * Search job titles based on query string
     *
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchJobTitles(string $query)
    {
        return $this->jobOpeningRepository->searchTitles($query);
    }
}
