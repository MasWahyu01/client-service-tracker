<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'password' => Hash::make('password'), // password: password
            ]
        );

        // Staff
        User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Operational Staff',
                'role' => 'staff',
                'password' => Hash::make('password'),
            ]
        );

        // Viewer / Manager
        User::updateOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'Manager Viewer',
                'role' => 'viewer',
                'password' => Hash::make('password'),
            ]
        );
    }
}
