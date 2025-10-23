<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Str;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function getActiveCategories()
    {
        return $this->categoryRepository->getActive();
    }

    public function getCategoryById(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function getCategoryBySlug(string $slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function createCategory(array $data)
    {
        // Auto-generate slug if not provided
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        return $this->categoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        // Auto-generate slug if name_en changed and slug not provided
        if (isset($data['name_en']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
