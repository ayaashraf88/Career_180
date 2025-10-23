<?php
namespace App\DTOs\Lesson;
class MarkAsCompletedData
{
    public function __construct(
        public readonly int $lesson_id,
        public readonly int $student_id,
        public readonly bool $is_completed
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            lesson_id: $request->lesson_id,
            student_id: $request->student_id,
            is_completed: $request->is_completed
 
        );
    }
}