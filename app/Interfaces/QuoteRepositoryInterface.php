<?php

namespace App\Interfaces;

interface QuoteRepositoryInterface
{
    public function all(array $filters = []);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getByStatus(string $status);
    public function getPending();
}
