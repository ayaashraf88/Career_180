<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Student;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\CompletedLesson;
use App\Notifications\CourseCompletedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CourseConstraintsTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_slugs_must_be_unique()
    {
       // Create a course with a specific slug
        $course1 = Course::factory()->create([
            'name' => 'Python Programming',
            'slug' => 'python-programming'
        ]);

        // Attempt to create another course with the same slug
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Course::factory()->create([
            'name' => 'Python Programming 2',
            'slug' => 'python-programming' // Same slug as first course
        ]);
    }

     public function test_concurrent_lesson_completion_maintains_consistency()
    {
        // Create test data
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lessons = Lesson::factory(3)->create(['module_id' => $module->id]);
        
        /** @var \App\Models\Student */
        $student = Student::factory()->create();
        
        $enrollment = Enrollment::factory()->create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'progress' => 0,
            'completed_at' => null
        ]);

        // Start a database transaction
        DB::beginTransaction();
        try {
            // Complete first lesson
            CompletedLesson::create([
                'lesson_id' => $lessons[0]->id,
                'student_id' => $student->id,
                'is_completed' => true,
                'completed_at' => now()
            ]);

            // Simulate concurrent completion of second lesson
            CompletedLesson::create([
                'lesson_id' => $lessons[1]->id,
                'student_id' => $student->id,
                'is_completed' => true,
                'completed_at' => now()
            ]);

            // Update progress
            $trackData = new \App\DTOs\Lesson\TrackProgressData($course->id, $student->id);
            $action = new \App\Actions\Lesson\TrackProgress($course->id, $student->id);
            $progress = $action->execute($trackData);

            // Verify progress is correctly calculated
            $enrollment->refresh();
            $expectedProgress = round((2 / 3) * 100, 2); // 2 out of 3 lessons completed
            
            $this->assertEquals($expectedProgress, $enrollment->progress);
            $this->assertNull($enrollment->completed_at); // Should not be marked complete yet

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}