<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::updateOrCreate(
            ['email' => 'admin@izifai.com'],
            [
                'name' => 'Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'super_admin',
            ]
        );

        \App\Models\Admin::updateOrCreate(
            ['email' => 'support@izifai.com'],
            [
                'name' => 'Support Agent',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'support',
            ]
        );
    }
}
