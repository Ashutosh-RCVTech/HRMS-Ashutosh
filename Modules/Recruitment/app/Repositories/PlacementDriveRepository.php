<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Repositories\Interfaces\College\PlacementDriveRepositoryInterface;
use Modules\Recruitment\Models\PlacementDrive;
use Carbon\Carbon;

class PlacementDriveRepository implements PlacementDriveRepositoryInterface
{
    protected $model;

    public function __construct(PlacementDrive $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getActiveDrives()
    {
        return $this->model->where('status', 'active')
            ->where('drive_date', '>=', Carbon::today())
            ->orderBy('drive_date', 'asc')
            ->get();
    }

    public function getUpcomingDrives($collegeId, $limit = 5)
    {
        return $this->model->where('college_id', $collegeId)
            ->where('drive_date', '>', Carbon::now())
            ->orderBy('drive_date', 'asc')
            ->take($limit)
            ->get();
    }

    public function getCompletedDrives()
    {
        return $this->model->where('status', 'completed')
            ->orderBy('drive_date', 'desc')
            ->get();
    }

    public function getDrivesByCollege($collegeId)
    {
        return $this->model->where('college_id', $collegeId)
            ->orderBy('drive_date', 'desc')
            ->get();
    }

    public function getDrivesByDate($date)
    {
        $date = Carbon::parse($date)->startOfDay();
        return $this->model->whereDate('drive_date', $date)
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function getDrivesByDateRange($startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();
        return $this->model->whereBetween('drive_date', [$startDate, $endDate])
            ->orderBy('drive_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function getDrivesByCity($city)
    {
        return $this->model->where('city', $city)
            ->orderBy('drive_date', 'desc')
            ->get();
    }

    public function getDrivesByState($state)
    {
        return $this->model->where('state', $state)
            ->orderBy('drive_date', 'desc')
            ->get();
    }

    public function getDrivesByCountry($country)
    {
        return $this->model->where('country', $country)
            ->orderBy('drive_date', 'desc')
            ->get();
    }

    public function searchDrives($query)
    {
        return $this->model->where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('company_name', 'like', "%{$query}%")
                ->orWhere('venue', 'like', "%{$query}%")
                ->orWhere('city', 'like', "%{$query}%");
        })->orderBy('drive_date', 'desc')
            ->get();
    }

    public function getActiveCount($collegeId)
    {
        return $this->model->where('college_id', $collegeId)
            ->where('status', 'active')
            ->count();
    }

    public function getUpcomingCount($collegeId)
    {
        return $this->model->where('college_id', $collegeId)
            ->where('drive_date', '>', Carbon::now())
            ->count();
    }

    public function getCompletedCount($collegeId)
    {
        return $this->model->where('college_id', $collegeId)
            ->where('status', 'completed')
            ->count();
    }

    public function getTotalStudents($collegeId)
    {
        return $this->model->where('college_id', $collegeId)
            ->where('status', 'active')
            ->sum('registered_students');
    }

    public function getCandidatePlacementDrives($candidateId, $filters = [])
    {
        // Dummy data for now
        return [
            [
                'id' => 1,
                'company_name' => 'Tech Corp',
                'position' => 'Software Engineer',
                'drive_date' => '2024-04-15',
                'status' => 'upcoming',
                'test_status' => 'not_started',
                'result_status' => null,
                'package' => '12 LPA',
                'location' => 'Bangalore',
                'description' => 'Full stack developer position with 2+ years experience'
            ],
            [
                'id' => 2,
                'company_name' => 'Data Systems',
                'position' => 'Data Analyst',
                'drive_date' => '2024-04-10',
                'status' => 'completed',
                'test_status' => 'completed',
                'result_status' => 'passed',
                'package' => '8 LPA',
                'location' => 'Hyderabad',
                'description' => 'Data analysis role with Python and SQL skills'
            ],
            [
                'id' => 3,
                'company_name' => 'Cloud Solutions',
                'position' => 'DevOps Engineer',
                'drive_date' => '2024-04-20',
                'status' => 'upcoming',
                'test_status' => 'not_started',
                'result_status' => null,
                'package' => '15 LPA',
                'location' => 'Mumbai',
                'description' => 'DevOps role with AWS and Kubernetes experience'
            ]
        ];
    }

    public function getPlacementDriveDetails($driveId)
    {
        // Dummy data for now
        return [
            'id' => $driveId,
            'company_name' => 'Tech Corp',
            'position' => 'Software Engineer',
            'drive_date' => '2024-04-15',
            'status' => 'upcoming',
            'test_status' => 'not_started',
            'result_status' => null,
            'package' => '12 LPA',
            'location' => 'Bangalore',
            'description' => 'Full stack developer position with 2+ years experience',
            'requirements' => [
                '2+ years of experience',
                'Strong in PHP, Laravel',
                'Knowledge of React/Vue.js',
                'Good communication skills'
            ]
        ];
    }

    public function updateTestStatus($driveId, $candidateId, $status)
    {
        // Dummy implementation
        return true;
    }
}
