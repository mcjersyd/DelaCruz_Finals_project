<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HandleFileUploads
{
    /**
     * Handle photo upload
     */
    public function uploadPhoto($file, $directory)
    {
        if ($file && $file->isValid()) {
            return $file->store($directory, 'public');
        }
        return null;
    }

    /**
     * Delete old photo and upload new one
     */
    public function updatePhoto($oldPhoto, $newFile, $directory)
    {
        // Delete old photo if exists
        if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
            Storage::disk('public')->delete($oldPhoto);
        }

        // Upload new photo
        if ($newFile && $newFile->isValid()) {
            return $newFile->store($directory, 'public');
        }

        return $oldPhoto;
    }
}
