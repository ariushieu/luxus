<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@luxus.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@123'),
            ]
        );

        // You can add more admin users here
        Admin::updateOrCreate(
            ['email' => 'demo@luxus.com'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('Demo@123'),
            ]
        );
    }
}
