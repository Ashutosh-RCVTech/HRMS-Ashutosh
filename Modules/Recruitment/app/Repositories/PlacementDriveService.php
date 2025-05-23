<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\Interfaces\College\PlacementDriveRepositoryInterface;
use Modules\Recruitment\Services\Interfaces\PlacementDriveServiceInterface;
use Carbon\Carbon;

class PlacementDriveService implements PlacementDriveServiceInterface
{
    protected $placementDriveRepository;

    public function __construct(PlacementDriveRepositoryInterface $placementDriveRepository)
    {
        $this->placementDriveRepository = $placementDriveRepository;
    }

    public function getAllDrives()
    {
        return $this->placementDriveRepository->all();
    }

    public function getDriveById($id)
    {
        return $this->placementDriveRepository->findOrFail($id);
    }

    public function createDrive(array $data)
    {
        // Validate and format dates
        $data['drive_date'] = Carbon::parse($data['drive_date'])->format('Y-m-d');
        $data['start_time'] = Carbon::parse($data['start_time'])->format('H:i:s');
        $data['end_time'] = Carbon::parse($data['end_time'])->format('H:i:s');

        // Set initial status
        $data['status'] = 'active';

        return $this->placementDriveRepository->create($data);
    }

    public function updateDrive($id, array $data)
    {
        // Format dates if provided
        if (isset($data['drive_date'])) {
            $data['drive_date'] = Carbon::parse($data['drive_date'])->format('Y-m-d');
        }
        if (isset($data['start_time'])) {
            $data['start_time'] = Carbon::parse($data['start_time'])->format('H:i:s');
        }
        if (isset($data['end_time'])) {
            $data['end_time'] = Carbon::parse($data['end_time'])->format('H:i:s');
        }

        return $this->placementDriveRepository->update($id, $data);
    }

    public function deleteDrive($id)
    {
        return $this->placementDriveRepository->delete($id);
    }

    public function getActiveDrives()
    {
        return $this->placementDriveRepository->getActiveDrives();
    }

    public function getUpcomingDrives()
    {
        return $this->placementDriveRepository->getUpcomingDrives(auth()->guard('college')->id());
    }

    public function getCompletedDrives()
    {
        return $this->placementDriveRepository->getCompletedDrives();
    }

    public function getDrivesByCollege($collegeId)
    {
        return $this->placementDriveRepository->getDrivesByCollege($collegeId);
    }

    public function getDrivesByDate($date)
    {
        return $this->placementDriveRepository->getDrivesByDate($date);
    }

    public function getDrivesByDateRange($startDate, $endDate)
    {
        return $this->placementDriveRepository->getDrivesByDateRange($startDate, $endDate);
    }

    public function getDrivesByCity($city)
    {
        return $this->placementDriveRepository->getDrivesByCity($city);
    }

    public function getDrivesByState($state)
    {
        return $this->placementDriveRepository->getDrivesByState($state);
    }

    public function getDrivesByCountry($country)
    {
        return $this->placementDriveRepository->getDrivesByCountry($country);
    }

    public function searchDrives($query)
    {
        return $this->placementDriveRepository->searchDrives($query);
    }

    public function completeDrive($id)
    {
        return $this->placementDriveRepository->update($id, [
            'status' => 'completed',
            'completed_at' => Carbon::now()
        ]);
    }

    public function cancelDrive($id)
    {
        return $this->placementDriveRepository->update($id, [
            'status' => 'cancelled',
            'cancelled_at' => Carbon::now()
        ]);
    }

    public function rescheduleDrive($id, $newDate, $newStartTime, $newEndTime)
    {
        return $this->placementDriveRepository->update($id, [
            'drive_date' => Carbon::parse($newDate)->format('Y-m-d'),
            'start_time' => Carbon::parse($newStartTime)->format('H:i:s'),
            'end_time' => Carbon::parse($newEndTime)->format('H:i:s'),
            'rescheduled_at' => Carbon::now()
        ]);
    }

    public function updateVenue($id, $newVenue)
    {
        return $this->placementDriveRepository->update($id, [
            'venue' => $newVenue,
            'venue_updated_at' => Carbon::now()
        ]);
    }

    public function updateMaxStudents($id, $maxStudents)
    {
        return $this->placementDriveRepository->update($id, [
            'max_students' => $maxStudents
        ]);
    }

    public function updateEligibilityCriteria($id, $criteria)
    {
        return $this->placementDriveRepository->update($id, [
            'eligibility_criteria' => $criteria,
            'criteria_updated_at' => Carbon::now()
        ]);
    }

    public function updateRequiredDocuments($id, $documents)
    {
        return $this->placementDriveRepository->update($id, [
            'required_documents' => $documents,
            'documents_updated_at' => Carbon::now()
        ]);
    }

    public function getCandidatePlacementDrives($candidateId, $filters = [])
    {
        return $this->placementDriveRepository->getCandidatePlacementDrives($candidateId, $filters);
    }

    public function getPlacementDriveDetails($driveId)
    {
        return $this->placementDriveRepository->getPlacementDriveDetails($driveId);
    }

    public function startTest($driveId, $candidateId)
    {
        // Check if test can be started
        $driveDetails = $this->getPlacementDriveDetails($driveId);
        
        if ($driveDetails['status'] !== 'upcoming') {
            return [
                'success' => false,
                'message' => 'This placement drive is not available for testing'
            ];
        }

        if ($driveDetails['test_status'] !== 'not_started') {
            return [
                'success' => false,
                'message' => 'Test has already been taken'
            ];
        }

        // Update test status
        $this->placementDriveRepository->updateTestStatus($driveId, $candidateId, 'in_progress');

        return [
            'success' => true,
            'message' => 'Test started successfully'
        ];
    }

    public function canStartTest($driveDetails)
    {
        return $driveDetails['status'] === 'upcoming' && 
               $driveDetails['test_status'] === 'not_started';
    }
}
