<?php

namespace Modules\Recruitment\Repositories\Interfaces\College;

interface PlacementDriveRepositoryInterface
{
    public function all();
    public function findOrFail($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getActiveDrives();
    public function getUpcomingDrives($collegeId, $limit = 5);
    public function getCompletedDrives();
    public function getDrivesByCollege($collegeId);
    public function getDrivesByDate($date);
    public function getDrivesByDateRange($startDate, $endDate);
    public function getDrivesByCity($city);
    public function getDrivesByState($state);
    public function getDrivesByCountry($country);
    public function searchDrives($query);
    public function getActiveCount($collegeId);
    public function getUpcomingCount($collegeId);
    public function getCompletedCount($collegeId);
    public function getTotalStudents($collegeId);
}
