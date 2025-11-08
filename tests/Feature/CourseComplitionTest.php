<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Student;
use Livewire\Livewire;
use App\Livewire\Courses\Index as CoursesIndex;
use App\Notifications\CourseCompletedNotification;
use Illuminate\Support\Facades\Notification;

it('Course Complition Test', function () {
    $course = Course::factory()->create();
    $module = Module::factory()->create(['course_id' => $course->id]);
    $lesson = Lesson::factory(2)->create(['module_id' => $module->id]);
    $student = Student::factory()->create();
    $this->actingAs($student, 'student');
    (new \App\Actions\Enrollment\CreateEnrollment($course->id, $student->id))->execute(\App\DTOs\Enrollment\CreateEnrollmentData::fromRequest((object)['course_id' => $course->id, 'student_id' => $student->id]));
    Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('markAsCompleted', $lesson[0]->id, true);
    Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('markAsCompleted', $lesson[1]->id, true);
    $trackData = new \App\DTOs\Lesson\TrackProgressData($course->id, $student->id);
    $action = new \App\Actions\Lesson\TrackProgress($course->id, $student->id);
    $progress = $action->execute($trackData);
    $expectedProgress = 100.0;

    $this->assertEquals($expectedProgress, $progress);
});
