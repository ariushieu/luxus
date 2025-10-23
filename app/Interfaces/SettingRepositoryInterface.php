<?php

namespace App\Interfaces;

interface SettingRepositoryInterface
{
    public function all();
    public function getByGroup(string $group);
    public function getByKey(string $key);
    public function updateOrCreate(string $key, array $data);
    public function deleteByKey(string $key);
}
