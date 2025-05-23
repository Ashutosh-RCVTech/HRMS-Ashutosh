<?php

namespace Modules\Recruitment\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Modules\Recruitment\Services\Interfaces\IFileUploadService;

class FileUploadService implements IFileUploadService
{
    /**
     * Upload a file to the specified path
     *
     * @param mixed $file The file to upload
     * @param string $path The storage path
     * @return string The path where the file was stored
     * @throws \Exception If upload fails
     */
    public function upload($file, string $path): string
    {
        try {
            // Generate a unique filename using timestamp and random string
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store the file with the custom filename
            $filePath = $file->storeAs($path, $filename, 'public');

            if (!$filePath) {
                throw new \Exception('File upload failed');
            }

            // Log the upload details
            Log::info('File Upload Details', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'stored_path' => $filePath,
                'exists' => Storage::disk('public')->exists($filePath)
            ]);

            return $filePath;
        } catch (\Exception $e) {
            Log::error('File Upload Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Error uploading file: ' . $e->getMessage());
        }
    }

    /**
     * Delete a file from storage
     *
     * @param string $path The file path to delete
     * @return bool Whether the deletion was successful
     */
    public function delete(string $path): bool
    {
        try {
            if ($this->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if a file exists
     *
     * @param string $path The file path to check
     * @return bool Whether the file exists
     */
    public function exists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }
}
