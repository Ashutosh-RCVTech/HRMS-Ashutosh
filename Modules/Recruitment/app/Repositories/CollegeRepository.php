<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\College;
use Modules\Recruitment\Repositories\Interfaces\College\CollegeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CollegeRepository extends CollegeBaseRepository implements CollegeRepositoryInterface
{
    public function __construct(College $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?College
    {
        return $this->model->where('email', $email)->first();
    }

    public function getActiveColleges(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    public function getVerifiedColleges(): Collection
    {
        return $this->model->where('is_verified', true)->get();
    }

    public function getCollegesByCity(string $city): Collection
    {
        return $this->model->where('city', $city)->get();
    }

    public function getCollegesByState(string $state): Collection
    {
        return $this->model->where('state', $state)->get();
    }

    public function getCollegesByCountry(string $country): Collection
    {
        return $this->model->where('country', $country)->get();
    }

    public function searchColleges(string $query): Collection
    {
        return $this->model->where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('city', 'like', "%{$query}%")
                ->orWhere('state', 'like', "%{$query}%")
                ->orWhere('country', 'like', "%{$query}%");
        })->get();
    }

    public function getCollegesWithActiveDrives(): Collection
    {
        return $this->model->whereHas('placementDrives', function ($query) {
            $query->where('is_active', true)
                ->where('is_completed', false)
                ->where('drive_date', '>=', now());
        })->get();
    }
}
