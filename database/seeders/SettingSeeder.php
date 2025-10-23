<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Home Page Settings
            [
                'key' => 'home_hero_title',
                'value_vi' => 'Thiết kế Nội thất Sang trọng',
                'value_en' => 'Luxury Interior Design',
                'type' => 'text',
                'group' => 'home',
            ],
            [
                'key' => 'home_hero_subtitle',
                'value_vi' => 'Tạo không gian sống đẳng cấp cho bạn',
                'value_en' => 'Creating elegant living spaces for you',
                'type' => 'text',
                'group' => 'home',
            ],

            // About Page Settings
            [
                'key' => 'about_title',
                'value_vi' => 'Về Chúng Tôi',
                'value_en' => 'About Us',
                'type' => 'text',
                'group' => 'about',
            ],
            [
                'key' => 'about_description',
                'value_vi' => 'Chúng tôi là đội ngũ thiết kế nội thất chuyên nghiệp với nhiều năm kinh nghiệm.',
                'value_en' => 'We are a professional interior design team with years of experience.',
                'type' => 'textarea',
                'group' => 'about',
            ],

            // Contact Page Settings
            [
                'key' => 'contact_email',
                'value_vi' => 'contact@luxus.com',
                'value_en' => 'contact@luxus.com',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value_vi' => '+84 123 456 789',
                'value_en' => '+84 123 456 789',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_address_vi',
                'value_vi' => '123 Đường ABC, Quận 1, TP.HCM',
                'value_en' => '123 ABC Street, District 1, HCMC',
                'type' => 'text',
                'group' => 'contact',
            ],

            // General Settings
            [
                'key' => 'site_name',
                'value_vi' => 'Luxus Interior Design',
                'value_en' => 'Luxus Interior Design',
                'type' => 'text',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
