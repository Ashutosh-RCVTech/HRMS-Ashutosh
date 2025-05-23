<?php

namespace Modules\Recruitment\Repositories\Interfaces\College;

interface CollegeRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email);
    public function getActiveColleges();
    public function getVerifiedColleges();
    public function getCollegesByCity(string $city);
    public function getCollegesByState(string $state);
    public function getCollegesByCountry(string $country);
    public function searchColleges(string $query);
    public function getCollegesWithActiveDrives();
}
