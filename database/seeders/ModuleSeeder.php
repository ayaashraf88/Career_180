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
                ['name' => 'Introduction to the Course','order'=>1],
                ['name' => 'Basic Concepts','order'=>5],
                ['name' => 'Advanced Topics','order'=>3],
                ['name' => 'Practical Applications','order'=>4],
                ['name' => 'Final Project','order'=>4],
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