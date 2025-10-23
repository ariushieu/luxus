<?php

namespace App\Repositories;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    public function all()
    {
        return Setting::all();
    }

    public function getByGroup(string $group)
    {
        return Setting::where('group', $group)->get();
    }

    public function getByKey(string $key)
    {
        return Setting::where('key', $key)->first();
    }

    public function updateOrCreate(string $key, array $data)
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            $data
        );
    }

    public function deleteByKey(string $key)
    {
        return Setting::where('key', $key)->delete();
    }
}
