<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Create staff user
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => 'password',
            'role' => 'staff',
        ]);

        // Create regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        // Create departments
        $departments = [
            ['name' => 'IT Support', 'description' => 'Technical support for IT related issues'],
            ['name' => 'HR', 'description' => 'Human Resources department'],
            ['name' => 'Finance', 'description' => 'Financial department'],
            ['name' => 'Operations', 'description' => 'Operations department'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
