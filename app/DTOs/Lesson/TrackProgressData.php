<?php
namespace App\DTOs\Lesson;
class TrackProgressData
{
    public function __construct(
        public readonly int $course_id,
        public readonly int $student_id
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            course_id: $request->course_id,
            student_id: $request->student_id
        );
    }
}