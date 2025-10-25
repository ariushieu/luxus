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

        // Return settings as objects, keyed by their key - for web views
        return $settings->mapWithKeys(function ($setting) {
            return [$setting->key => $setting];
        });
    }

    /**
     * Get settings by group for API (returns simple key-value pairs)
     */
    public function getSettingsByGroupForApi(string $group, string $locale = 'vi')
    {
        $settings = $this->settingRepository->getByGroup($group);

        // Return key-value pairs with the correct locale for API
        return $settings->mapWithKeys(function ($setting) use ($locale) {
            return [$setting->key => [
                'value' => $setting->getValueByLocale($locale),
                'type' => $setting->type,
            ]];
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
