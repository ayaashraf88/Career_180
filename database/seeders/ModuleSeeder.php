<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            Module::factory()->count(rand(3, 8))->create([
                'course_id' => $course->id,
            ]);
        }

        // Create specific modules for the first course
        $firstCourse = Course::first();
        if ($firstCourse) {
            $modules = [
                ['name' => 'Introduction to the Course'],
                ['name' => 'Basic Concepts'],
                ['name' => 'Advanced Topics'],
                ['name' => 'Practical Applications'],
                ['name' => 'Final Project'],
            ];

            foreach ($modules as $module) {
                Module::factory()->create([
                    'course_id' => $firstCourse->id,
                    'name' => $module['name'],
                ]);
            }
        }
    }
}