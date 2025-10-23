<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary;

class CloudinaryService
{
    protected $cloudinary;

    public function __construct()
    {
        // Initialize Cloudinary with URL
        $this->cloudinary = new Cloudinary(config('filesystems.disks.cloudinary.url'));
    }

    /**
     * Upload image to Cloudinary using SDK directly
     */
    public function uploadImage(UploadedFile $file, string $folder = 'Luxus'): array
    {
        try {
            // Upload directly using Cloudinary SDK
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => $folder,
                'resource_type' => 'image',
            ]);

            // Log the result
            Log::info('Cloudinary SDK upload', [
                'folder' => $folder,
                'public_id' => $result['public_id'],
                'secure_url' => $result['secure_url'],
            ]);

            return [
                'public_id' => $result['public_id'],
                'url' => $result['secure_url'],
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
            ];
        } catch (\Exception $e) {
            throw new \Exception('Failed to upload image to Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Delete image from Cloudinary
     */
    public function deleteImage(string $publicId): bool
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId);
            return isset($result['result']) && $result['result'] === 'ok';
        } catch (\Exception $e) {
            throw new \Exception('Failed to delete image from Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Get optimized image URL
     */
    public function getOptimizedUrl(string $publicId, array $transformations = []): string
    {
        $cloudName = config('filesystems.disks.cloudinary.cloud');
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$publicId}";
    }
}
