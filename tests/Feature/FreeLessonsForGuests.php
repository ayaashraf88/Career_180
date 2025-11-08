<?php

use App\Livewire\Courses\Index as CoursesIndex;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Student;
use App\Models\Enrollment;
use Livewire\Livewire;

it('allows guests to access preview lessons but blocks locked lessons', function () {
   $course = Course::factory()->create();
    $module = Module::factory()->create(['course_id' => $course->id]);
    $previewLesson = Lesson::factory()->create(['module_id' => $module->id, 'visible' => true]);
    $lockedLesson = Lesson::factory()->locked()->create(['module_id' => $module->id]);
    auth()->guard('student')->logout();
    $component = Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('selectModule', $module->id)
        ->call('selectLesson', $previewLesson->id);
    $component->assertSee($previewLesson->title)
        ->assertSee($previewLesson->content);
    $component = Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('selectModule', $module->id)
        ->call('selectLesson', $lockedLesson->id);

    $component->assertSee('Lesson Locked');

});

it('allows enrolled students to access locked lessons', function () {
  $course = Course::factory()->create();
    $module = Module::factory()->create(['course_id' => $course->id]);

    $lockedLesson = Lesson::factory()->locked()->create(['module_id' => $module->id]);

    $student = Student::factory()->create();
    (new \App\Actions\Enrollment\CreateEnrollment($course->id, $student->id))->execute(\App\DTOs\Enrollment\CreateEnrollmentData::fromRequest((object)['course_id' => $course->id, 'student_id' => $student->id]));

    $this->actingAs($student, 'student');

    $component = Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('selectModule', $module->id)
        ->call('selectLesson', $lockedLesson->id);

    $component->assertDontSee('Lesson Locked')
        ->assertSee($lockedLesson->content);
});
