<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = Project::with(['category', 'primaryImage']);

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('display_order')->get();
    }

    public function getActive(array $filters = [])
    {
        $query = Project::where('is_active', true)
            ->with(['category', 'primaryImage']);

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('display_order')->orderBy('created_at', 'desc');
    }

    public function getFeatured(int $limit = 6)
    {
        return Project::where('is_active', true)
            ->where('is_featured', true)
            ->with(['category', 'primaryImage'])
            ->orderBy('display_order')
            ->limit($limit)
            ->get();
    }

    public function find(int $id)
    {
        return Project::with(['category', 'images'])->findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Project::where('slug', $slug)
            ->with(['category', 'images', 'primaryImage'])
            ->firstOrFail();
    }

    public function getByCategory(int $categoryId, array $filters = [])
    {
        $query = Project::where('category_id', $categoryId)
            ->where('is_active', true)
            ->with(['category', 'primaryImage']);

        return $query->orderBy('display_order')->orderBy('created_at', 'desc');
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update(int $id, array $data)
    {
        $project = $this->find($id);
        $project->update($data);
        return $project;
    }

    public function delete(int $id)
    {
        $project = $this->find($id);
        return $project->delete();
    }
}
