<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_vi' => 'Nhà Ở',
                'name_en' => 'Housing',
                'slug' => 'housing',
                'description_vi' => 'Thiết kế nội thất cho nhà ở, căn hộ, biệt thự',
                'description_en' => 'Interior design for houses, apartments, villas',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name_vi' => 'Thương Mại',
                'name_en' => 'Commercial',
                'slug' => 'commercial',
                'description_vi' => 'Thiết kế nội thất cho cửa hàng, showroom, nhà hàng',
                'description_en' => 'Interior design for shops, showrooms, restaurants',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'name_vi' => 'Văn Phòng',
                'name_en' => 'Office',
                'slug' => 'office',
                'description_vi' => 'Thiết kế nội thất cho văn phòng làm việc',
                'description_en' => 'Interior design for office spaces',
                'display_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
