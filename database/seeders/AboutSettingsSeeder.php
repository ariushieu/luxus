<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class AboutSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'about_title',
                'value_vi' => 'LUXUS - KIẾN TẠO KHÔNG GIAN VƯỢT TRỜI',
                'value_en' => null,
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_intro',
                'value_vi' => 'Chào mừng bạn đến với trang web của LUXUS – nơi bạn sẽ khám phá vẻ đẹp và ý nghĩa của kiến trúc. Hơn thế nữa, đây cũng chính là điểm bắt đầu trong cuộc thám hiểm tâm hồn và ý tưởng của bạn.',
                'value_en' => 'Welcome to LUXUS website – where you\'ll explore the beauty and meaning of architecture. Moreover, this is your starting point for a journey into your soul and ideas.',
                'group' => 'about',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_content',
                'value_vi' => 'LUXUS – đặt trụ sở tại Hà Nội đã thực hiện nhiều dự án kiến trúc và nội thất cho các khách hàng Việt Nam và Đông Nam Á. LUXUS lấy tiêu chí về chất lượng cuộc sống con người, tinh thần, thẩm mỹ và công năng. Chúng tôi mong muốn mang lại cho khách hàng những trải nghiệm mới về "Không Gian Sống", từ việc hoàn chỉnh về công năng, tối ưu về tiện ích và đa dạng về thẩm mỹ.',
                'value_en' => null,
                'group' => 'about',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_image_1',
                'value_vi' => null,
                'value_en' => null,
                'group' => 'about',
                'type' => 'image',
            ],
            [
                'key' => 'about_image_2',
                'value_vi' => null,
                'value_en' => null,
                'group' => 'about',
                'type' => 'image',
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
