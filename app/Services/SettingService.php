<?php

namespace App\Services;

use App\Interfaces\SettingRepositoryInterface;

class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getAllSettings()
    {
        return $this->settingRepository->all();
    }

    public function getSettingsByGroup(string $group, string $locale = 'vi')
    {
        $settings = $this->settingRepository->getByGroup($group);

        return $settings->mapWithKeys(function ($setting) use ($locale) {
            return [$setting->key => $setting->getValueByLocale($locale)];
        });
    }

    public function getSetting(string $key, string $locale = 'vi')
    {
        $setting = $this->settingRepository->getByKey($key);
        return $setting ? $setting->getValueByLocale($locale) : null;
    }

    public function updateSetting(string $key, array $data)
    {
        return $this->settingRepository->updateOrCreate($key, $data);
    }

    public function deleteSetting(string $key)
    {
        return $this->settingRepository->deleteByKey($key);
    }
}
