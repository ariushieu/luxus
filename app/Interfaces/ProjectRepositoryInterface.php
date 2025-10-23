<?php

namespace App\Interfaces;

interface ProjectRepositoryInterface
{
    public function all(array $filters = []);
    public function getActive(array $filters = []);
    public function getFeatured(int $limit = 6);
    public function find(int $id);
    public function findBySlug(string $slug);
    public function getByCategory(int $categoryId, array $filters = []);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
