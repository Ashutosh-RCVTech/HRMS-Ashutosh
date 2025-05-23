<?php

namespace Modules\Recruitment\Services\Interfaces;

interface PlacementDriveServiceInterface
{
    public function getAllDrives();
    public function getDriveById($id);
    public function createDrive(array $data);
    public function updateDrive($id, array $data);
    public function deleteDrive($id);
    public function getActiveDrives();
    public function getUpcomingDrives();
    public function getCompletedDrives();
    public function getDrivesByCollege($collegeId);
    public function getDrivesByDate($date);
    public function getDrivesByDateRange($startDate, $endDate);
    public function getDrivesByCity($city);
    public function getDrivesByState($state);
    public function getDrivesByCountry($country);
    public function searchDrives($query);
    public function completeDrive($id);
    public function cancelDrive($id);
    public function rescheduleDrive($id, $newDate, $newStartTime, $newEndTime);
    public function updateVenue($id, $newVenue);
    public function updateMaxStudents($id, $maxStudents);
    public function updateEligibilityCriteria($id, $criteria);
    public function updateRequiredDocuments($id, $documents);
}
