<?php

namespace Modules\Recruitment\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Recruitment\Models\College;
use Modules\Recruitment\Services\FileUploadService;
use Modules\Recruitment\Services\Interfaces\IFileUploadService;
use Modules\Recruitment\Services\Interfaces\CollegeServiceInterface;

class CollegeService implements CollegeServiceInterface
{
    protected $model;
    public function __construct(College $model, protected IFileUploadService $fileUploadService)
    {
        $this->model = $model;
    }

    /**
     * Create a new college.
     *
     * @param array $data
     * @return College
     */
    public function create(array $data): College
    {
        $data['password'] = Hash::make($data['password']);
        return $this->model->create($data);
    }

    /**
     * Update an existing college.
     *
     * @param int $id
     * @param array $data
     * @return College
     */
    public function update(int $id, array $data): College
    {
        $college = $this->find($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $college->update($data);
        return $college;
    }

    /**
     * Find a college by ID.
     *
     * @param int $id
     * @return College|null
     */
    public function find(int $id): ?College
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get all colleges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Delete a college.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $college = $this->find($id);
        if ($college) {
            // Delete logo if exists
            if ($college->logo) {
                Storage::disk('public')->delete($college->logo);
            }
            return $college->delete();
        }
        return false;
    }

    /**
     * Update college logo
     *
     * @param int $id College ID
     * @param UploadedFile $logo Logo file to upload
     * @return College Updated college model
     * @throws \Exception
     */
    public function updateLogo(int $id, UploadedFile $logo): College
    {
        // Find the college
        $college = College::findOrFail($id);

        // Validate file
        if (!$logo->isValid()) {
            throw new \Exception('Invalid file upload');
        }

        // Log upload attempt
        Log::info('Logo Upload Attempt', [
            'college_id' => $id,
            'original_filename' => $logo->getClientOriginalName(),
            'mime_type' => $logo->getMimeType()
        ]);

        try {
            // Delete existing logo if it exists
            if ($college->logo) {
                $this->fileUploadService->delete($college->logo);
            }

            // Upload new logo
            $path = $this->fileUploadService->upload($logo, 'college-logos');

            // Verify the file was uploaded successfully
            if (!$this->fileUploadService->exists($path)) {
                throw new \Exception('File was not stored successfully');
            }

            // Log successful upload
            Log::info('Logo Stored Successfully', [
                'stored_path' => $path,
                'file_size' => $logo->getSize()
            ]);

            // Update college model with new logo path
            $college->update(['logo' => $path]);

            return $college;
        } catch (\Exception $e) {
            // Log and rethrow the exception
            Log::error('Logo Upload Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Mark college as verified.
     *
     * @param int $id
     * @return College
     */
    public function markAsVerified(int $id): College
    {
        $college = $this->find($id);
        if ($college) {
            $college->update(['is_verified' => true]);
        }
        return $college;
    }

    /**
     * Mark college as active.
     *
     * @param int $id
     * @return College
     */
    public function markAsActive(int $id): College
    {
        $college = $this->find($id);
        if ($college) {
            $college->update(['is_active' => true]);
        }
        return $college;
    }

    /**
     * Get all colleges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllColleges()
    {
        return $this->model->all();
    }

    /**
     * Get college by ID.
     *
     * @param int $id
     * @return College|null
     */
    public function getCollegeById($id)
    {
        return $this->find($id);
    }

    /**
     * Get active colleges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveColleges()
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Get verified colleges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVerifiedColleges()
    {
        return $this->model->where('is_verified', true)->get();
    }

    /**
     * Get colleges by city.
     *
     * @param string $city
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollegesByCity($city)
    {
        return $this->model->where('city', $city)->get();
    }

    /**
     * Get colleges by state.
     *
     * @param string $state
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollegesByState($state)
    {
        return $this->model->where('state', $state)->get();
    }

    /**
     * Get colleges by country.
     *
     * @param string $country
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollegesByCountry($country)
    {
        return $this->model->where('country', $country)->get();
    }

    /**
     * Search colleges.
     *
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchColleges($query)
    {
        return $this->model->where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('city', 'like', "%{$query}%")
                ->orWhere('state', 'like', "%{$query}%");
        })->get();
    }

    /**
     * Get colleges with active drives.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollegesWithActiveDrives()
    {
        return $this->model->whereHas('placementDrives', function ($query) {
            $query->where('status', 'active');
        })->get();
    }

    /**
     * Verify a college.
     *
     * @param int $id
     * @return College
     */
    public function verifyCollege($id)
    {
        return $this->markAsVerified($id);
    }

    /**
     * Deactivate a college.
     *
     * @param int $id
     * @return College
     */
    public function deactivateCollege($id)
    {
        $college = $this->find($id);
        if ($college) {
            $college->update(['is_active' => false]);
        }
        return $college;
    }

    /**
     * Activate a college.
     *
     * @param int $id
     * @return College
     */
    public function activateCollege($id)
    {
        return $this->markAsActive($id);
    }

    /**
     * Update college logo.
     *
     * @param int $id
     * @param UploadedFile $logoFile
     * @return College
     */
    public function updateCollegeLogo($id, $logoFile)
    {
        return $this->updateLogo($id, $logoFile);
    }
}
