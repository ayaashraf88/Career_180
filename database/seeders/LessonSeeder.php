<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $modules = Module::all();

        foreach ($modules as $module) {
            Lesson::factory()->count(rand(2, 6))->create([
                'module_id' => $module->id,
            ]);
        }

        // Create some specific lessons
        $firstModule = Module::first();
        if ($firstModule) {
            $lessons = [
                [
                    'title' => 'Welcome to the Course',
                    'content' => 'Introduction and course overview.',
                    'video_url' => '01K7W0C8X6549C5EQJJ920JRSJ.mp4',
                    'duration' => 10,
                ],
                [
                    'title' => 'Setting Up Your Environment',
                    'content' => 'Learn how to set up your development environment.',
                    'video_url' => '01K7W0C8X6549C5EQJJ920JRSJ.mp4',
                    'duration' => 25,
                ],
            ];

            foreach ($lessons as $lesson) {
                Lesson::factory()->create(array_merge($lesson, [
                    'module_id' => $firstModule->id,
                ]));
            }
        }
    }
}
