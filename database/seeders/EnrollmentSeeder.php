<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $courses = Course::all();

        // Each student enrolls in 1-4 random courses
        foreach ($students as $student) {
            $randomCourses = $courses->random(rand(1, 2));
            
            foreach ($randomCourses as $course) {
                Enrollment::factory()->create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ]);
            }
        }

        // Ensure test student has enrollments
        $testStudent = Student::where('email', 'student@example.com')->first();
        if ($testStudent) {
            $testCourses = $courses->take(3);
            foreach ($testCourses as $course) {
                Enrollment::factory()->create([
                    'student_id' => $testStudent->id,
                    'course_id' => $course->id,
                    'completed_at' => now(),
                ]);
            }
        }
    }
}