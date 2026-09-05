<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
            ProjectSeeder::class,
            TestimonialSeeder::class,
            TeamMemberSeeder::class,
            PostSeeder::class,
            PageSettingSeeder::class,
            ContactMessageSeeder::class,
            PageSeeder::class,
            CalendarEventSeeder::class,
        ]);
    }
}

