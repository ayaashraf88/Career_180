<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Course::factory()->count(10)->create();
        
        // Create some specific courses
        $courses = [
            [
                'name' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of web development including HTML, CSS, and JavaScript.',
                'image' => '01K7VQ460X2DYFRKBR5NXAYN60.png',
                
            ],
            [
                'name' => 'Laravel Masterclass',
                'description' => 'Master Laravel framework with advanced techniques and best practices.',
                'image' => '01K7VQ460X2DYFRKBR5NXAYN60.png',
            ],
            [
                'name' => 'Database Design',
                'description' => 'Learn how to design and optimize databases for modern applications.',
                'image' => '01K7VQ460X2DYFRKBR5NXAYN60.png',
            ],
            
        ];

        foreach ($courses as $course) {
            Course::factory()->create($course);
        }
    }
}