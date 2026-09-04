<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Editor
        User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
