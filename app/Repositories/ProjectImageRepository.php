<?php

namespace App\Repositories;

use App\Interfaces\ProjectImageRepositoryInterface;
use App\Models\ProjectImage;

class ProjectImageRepository implements ProjectImageRepositoryInterface
{
    public function getByProject(int $projectId)
    {
        return ProjectImage::where('project_id', $projectId)
            ->orderBy('display_order')
            ->get();
    }

    public function find(int $id)
    {
        return ProjectImage::findOrFail($id);
    }

    public function create(array $data)
    {
        return ProjectImage::create($data);
    }

    public function update(int $id, array $data)
    {
        $image = $this->find($id);
        $image->update($data);
        return $image;
    }

    public function delete(int $id)
    {
        $image = $this->find($id);
        return $image->delete();
    }

    public function deleteByPublicId(string $publicId)
    {
        return ProjectImage::where('cloudinary_public_id', $publicId)->delete();
    }
}
