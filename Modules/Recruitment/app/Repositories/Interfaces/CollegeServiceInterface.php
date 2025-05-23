<?php

namespace Modules\Recruitment\Services\Interfaces;

use Illuminate\Http\UploadedFile;
use Modules\Recruitment\Models\College;

interface CollegeServiceInterface
{
    /**
     * Create a new college.
     *
     * @param array $data
     * @return College
     */
    public function create(array $data): College;

    /**
     * Update an existing college.
     *
     * @param int $id
     * @param array $data
     * @return College
     */
    public function update(int $id, array $data): College;

    /**
     * Find a college by ID.
     *
     * @param int $id
     * @return College|null
     */
    public function find(int $id): ?College;

    /**
     * Get all colleges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Delete a college.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Update college logo
     *
     * @param int $id College ID
     * @param UploadedFile $logo Logo file to upload
     * @return College Updated college model
     */
    public function updateLogo(int $id, UploadedFile $logo): College;

    /**
     * Mark college as verified.
     *
     * @param int $id
     * @return College
     */
    public function markAsVerified(int $id): College;

    /**
     * Mark college as active.
     *
     * @param int $id
     * @return College
     */
    public function markAsActive(int $id): College;

    public function getAllColleges();
    public function getCollegeById($id);
    public function getActiveColleges();
    public function getVerifiedColleges();
    public function getCollegesByCity($city);
    public function getCollegesByState($state);
    public function getCollegesByCountry($country);
    public function searchColleges($query);
    public function getCollegesWithActiveDrives();
    public function verifyCollege($id);
    public function deactivateCollege($id);
    public function activateCollege($id);
    public function updateCollegeLogo($id, $logoFile);
}
