<?php

namespace App\Actions\Enrollment;

use App\DTOs\Enrollment\CreateEnrollmentData;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

// use function Spatie\Activitylog\activity;

class CreateEnrollment
{
    public function __construct(
        public readonly int $course_id,
        public readonly int $student_id,
    ) {}

    public function execute(CreateEnrollmentData $data)
    {
        $student = Student::findOrFail($data->student_id);
        $isEnrolled = $student->courses()->where('course_id', $data->course_id)->exists();
        if (!$isEnrolled) {
            DB::transaction(function ()use ($data) {

                Enrollment::firstOrCreate([
                    'course_id' => $data->course_id,
                    'student_id' => $data->student_id,
                    'progress' => 0,
                ]);
            });
            activity()
                ->causedBy($student)
                ->performedOn($data->course_id ? \App\Models\Course::find($this->course_id) : null)
                ->withProperties(['course_id' => $data->course_id, 'progress' => 0])
                ->log('user enrolled in the course');
        }
    }
}
