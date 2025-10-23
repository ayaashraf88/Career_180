<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\AdminFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StudentSeeder::class,
            CourseSeeder::class,
            ModuleSeeder::class,
            LessonSeeder::class,
            EnrollmentSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
