<?php

namespace Modules\Recruitment\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface IFileUploadService
{
    /**
     * Upload a file to the specified path
     *
     * @param mixed $file The file to upload
     * @param string $path The storage path
     * @return string The path where the file was stored
     */
    public function upload($file, string $path): string;

    /**
     * Delete a file from storage
     *
     * @param string $path The file path to delete
     * @return bool Whether the deletion was successful
     */
    public function delete(string $path): bool;

    /**
     * Check if a file exists
     *
     * @param string $path The file path to check
     * @return bool Whether the file exists
     */
    public function exists(string $path): bool;
}
