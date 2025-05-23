<?php

namespace Modules\Recruitment\Policies;

use Modules\Recruitment\Models\PlacementDrive;
use Modules\Recruitment\Models\College;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PlacementDrivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the college can view the placement drive.
     */
    public function view(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id;
    }

    /**
     * Determine whether the college can create placement drives.
     */
    public function create(College $college): bool
    {
        return true;
    }

    /**
     * Determine whether the college can update the placement drive.
     */
    public function update(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can delete the placement drive.
     */
    public function delete(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can complete the placement drive.
     */
    public function complete(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can cancel the placement drive.
     */
    public function cancel(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can reschedule the placement drive.
     */
    public function reschedule(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can update the venue.
     */
    public function updateVenue(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can update the maximum students.
     */
    public function updateMaxStudents(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can update the eligibility criteria.
     */
    public function updateEligibilityCriteria(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }

    /**
     * Determine whether the college can update the required documents.
     */
    public function updateRequiredDocuments(College $college, PlacementDrive $drive): bool
    {
        return $college->id === $drive->college_id && $drive->status === 'active';
    }
}
