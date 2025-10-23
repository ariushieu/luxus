<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function all();
    public function getActive();
    public function find(int $id);
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
