<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'category_id' => 1, // Housing
                'title_vi' => 'Căn hộ cao cấp Vinhomes Central Park',
                'title_en' => 'Vinhomes Central Park Luxury Apartment',
                'slug' => 'vinhomes-central-park-luxury-apartment',
                'description_vi' => 'Thiết kế nội thất hiện đại, sang trọng cho căn hộ 3 phòng ngủ',
                'description_en' => 'Modern and luxury interior design for 3-bedroom apartment',
                'content_vi' => 'Dự án thiết kế nội thất hoàn chỉnh cho căn hộ cao cấp tại Vinhomes Central Park. Phong cách hiện đại tối giản kết hợp với các chi tiết sang trọng.',
                'content_en' => 'Complete interior design project for luxury apartment at Vinhomes Central Park. Minimalist modern style combined with luxurious details.',
                'client_name' => 'Mr. Nguyen Van A',
                'location' => 'Ho Chi Minh City',
                'area' => '120.5',
                'year' => 2024,
                'status' => 'completed',
                'is_featured' => true,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'category_id' => 2, // Commercial
                'title_vi' => 'Showroom đồ nội thất Luxury Home',
                'title_en' => 'Luxury Home Furniture Showroom',
                'slug' => 'luxury-home-furniture-showroom',
                'description_vi' => 'Thiết kế showroom trưng bày sản phẩm nội thất cao cấp',
                'description_en' => 'Luxury furniture showroom design',
                'content_vi' => 'Không gian showroom được thiết kế để tối ưu việc trưng bày và giới thiệu sản phẩm với khách hàng.',
                'content_en' => 'Showroom space designed to optimize product display and customer presentation.',
                'client_name' => 'Luxury Home JSC',
                'location' => 'Hanoi',
                'area' => '250',
                'year' => 2024,
                'status' => 'completed',
                'is_featured' => true,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'category_id' => 3, // Office
                'title_vi' => 'Văn phòng công ty Tech Startup',
                'title_en' => 'Tech Startup Office',
                'slug' => 'tech-startup-office',
                'description_vi' => 'Văn phòng mở với không gian làm việc linh hoạt',
                'description_en' => 'Open office with flexible workspace',
                'content_vi' => 'Thiết kế văn phòng hiện đại cho công ty công nghệ với không gian mở, khu vực làm việc nhóm và phòng họp sáng tạo.',
                'content_en' => 'Modern office design for tech company with open space, team work areas and creative meeting rooms.',
                'client_name' => 'Tech Startup Co.',
                'location' => 'Ho Chi Minh City',
                'area' => '180',
                'year' => 2024,
                'status' => 'ongoing',
                'is_featured' => false,
                'is_active' => true,
                'display_order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
