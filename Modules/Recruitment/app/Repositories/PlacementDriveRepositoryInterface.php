<?php

namespace Modules\Recruitment\app\Repositories;

interface PlacementDriveRepositoryInterface
{
    public function getCandidatePlacementDrives($candidateId, $filters = []);
    public function getPlacementDriveDetails($driveId);
    public function updateTestStatus($driveId, $candidateId, $status);
} 