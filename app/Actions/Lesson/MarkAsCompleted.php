<?php

namespace App\Actions\Lesson;

use App\DTOs\Lesson\MarkAsCompletedData;
use App\Models\CompletedLesson;

class MarkAsCompleted
{
    public function __construct(
        public readonly int $lesson_id,
        public readonly int $student_id,
        public readonly bool $is_completed

    ) {}
    public function execute(MarkAsCompletedData $data)
    {
        $completedLesson = CompletedLesson::updateOrCreate(
            [
                'lesson_id' => $data->lesson_id,
                'student_id' => $data->student_id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );
        activity()
            ->causedBy($this->student_id ? \App\Models\Student::find($this->student_id) : null)
            ->performedOn($this->lesson_id ? \App\Models\Lesson::find($this->lesson_id) : null)
            ->withProperties(['lesson_id' => $data->lesson_id])
            ->log('lesson completed');
        return $completedLesson;
    }
}
