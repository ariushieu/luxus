<?php

namespace App\Services;

use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\ProjectImageRepositoryInterface;
use Illuminate\Support\Str;

class ProjectService
{
    protected $projectRepository;
    protected $projectImageRepository;
    protected $cloudinaryService;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        ProjectImageRepositoryInterface $projectImageRepository,
        CloudinaryService $cloudinaryService
    ) {
        $this->projectRepository = $projectRepository;
        $this->projectImageRepository = $projectImageRepository;
        $this->cloudinaryService = $cloudinaryService;
    }

    public function getAllProjects(array $filters = [])
    {
        return $this->projectRepository->all($filters);
    }

    public function getActiveProjects(array $filters = [])
    {
        return $this->projectRepository->getActive($filters);
    }

    public function getAllActiveProjects(array $filters = [])
    {
        return $this->projectRepository->getActive($filters)->paginate(12);
    }

    public function getFeaturedProjects(int $limit = 6)
    {
        return $this->projectRepository->getFeatured($limit);
    }

    public function getProjectById(int $id)
    {
        return $this->projectRepository->find($id);
    }

    public function getProjectBySlug(string $slug)
    {
        return $this->projectRepository->findBySlug($slug);
    }

    public function getProjectsByCategory(int $categoryId, ?int $limit = null, array $filters = [])
    {
        $query = $this->projectRepository->getByCategory($categoryId, $filters);

        if ($limit) {
            return $query->limit($limit)->get();
        }

        return $query->paginate(12);
    }

    public function createProject(array $data)
    {
        // Auto-generate slug if not provided
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title_en']);
        }

        return $this->projectRepository->create($data);
    }

    public function updateProject(int $id, array $data)
    {
        // Auto-generate slug if title_en changed and slug not provided
        if (isset($data['title_en']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title_en']);
        }

        return $this->projectRepository->update($id, $data);
    }

    public function deleteProject(int $id)
    {
        // Get project with images
        $project = $this->projectRepository->find($id);

        // Delete all images from Cloudinary
        foreach ($project->images as $image) {
            $this->cloudinaryService->deleteImage($image->cloudinary_public_id);
        }

        return $this->projectRepository->delete($id);
    }

    public function addProjectImage(int $projectId, $imageFile, array $data = [])
    {
        // Get project with category to determine folder
        $project = $this->projectRepository->find($projectId);
        $categorySlug = $project->category->slug ?? 'other';

        // Upload to Cloudinary with category folder: Luxus/housing/, Luxus/commercial/, etc.
        $folder = 'Luxus/' . $categorySlug;
        $uploadResult = $this->cloudinaryService->uploadImage($imageFile, $folder);

        // Save to database
        $imageData = array_merge($data, [
            'project_id' => $projectId,
            'cloudinary_public_id' => $uploadResult['public_id'],
            'cloudinary_url' => $uploadResult['url'],
        ]);

        return $this->projectImageRepository->create($imageData);
    }

    public function deleteProjectImage(int $imageId)
    {
        $image = $this->projectImageRepository->find($imageId);

        // Delete from Cloudinary
        $this->cloudinaryService->deleteImage($image->cloudinary_public_id);

        // Delete from database
        return $this->projectImageRepository->delete($imageId);
    }
}
