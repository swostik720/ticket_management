<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create branches
        $branches = [
            ['name' => 'Head Branch', 'address' => 'Main Street, City Center'],
            ['name' => 'North Branch', 'address' => 'North Avenue, Uptown'],
            ['name' => 'South Branch', 'address' => 'South Boulevard, Downtown'],
            ['name' => 'East Branch', 'address' => 'East Road, Suburb'],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }

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

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
            'username' => 'pmlil00001',
        ]);

        // Create head of department user
        User::create([
            'name' => 'Head of IT',
            'email' => 'head_it@example.com',
            'password' => 'password',
            'role' => 'head_of_department',
            'department_id' => 1, // IT Support
            'branch_id' => 1, // Head Branch
            'username' => 'pmlil00002',
        ]);

        // Create staff user
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => 'password',
            'role' => 'staff',
            'department_id' => 1, // IT Support
            'branch_id' => 2, // North Branch
            'username' => 'pmlil00003',
        ]);

        // Create head office staff user
        User::create([
            'name' => 'Head Office Staff',
            'email' => 'headoffice@example.com',
            'password' => 'password',
            'role' => 'head_office_staff',
            'department_id' => 1, // IT Support
            'branch_id' => 1, // Head Branch
            'username' => 'pmlil00004',
        ]);
    }
}
