<?php

use App\Livewire\Courses\Index as CoursesIndex;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
it('requires login to enroll', function () {
    $course = Course::factory()->create();
    auth()->guard('student')->logout();
    Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('enroll');
    expect(Enrollment::where('course_id', $course->id)->count())->toBe(0);
});

it('does not allow enrolling on draft courses', function () {
    if (! Schema::hasColumn('courses', 'is_draft') && ! Schema::hasColumn('courses', 'status')) {
        $this->markTestSkipped('No draft/status column on courses table');
    }

    $course = Course::factory()->create();
    if (Schema::hasColumn('courses', 'is_draft')) {
        $course->update(['is_draft' => true]);
    } else {
        $course->update(['status' => 'draft']);
    }

    $student = Student::factory()->create();
    $this->actingAs($student, 'student');

    Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('enroll');

    expect(Enrollment::where('course_id', $course->id)->count())->toBe(0);
});

it('enrollment is idempotent', function () {
    $course = Course::factory()->create();
    $student = Student::factory()->create();
    $this->actingAs($student, 'student');
    Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('enroll');
    Livewire::test(CoursesIndex::class, ['slug' => $course->slug])
        ->call('enroll');
    expect(Enrollment::where('course_id', $course->id)->where('student_id', $student->id)->count())->toBe(1);
});
