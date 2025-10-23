<?php

namespace App\Interfaces;

interface ProjectImageRepositoryInterface
{
    public function getByProject(int $projectId);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function deleteByPublicId(string $publicId);
}
