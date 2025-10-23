<?php

namespace App\Actions\Lesson;

use App\DTOs\Lesson\TrackProgressData;
use App\Models\CompletedLesson;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use function Spatie\Activitylog\activity;
use Illuminate\Support\Facades\Log;

class TrackProgress
{
    public function __construct(
        public readonly int $course_id,
        public readonly int $student_id,
    ) {}

    public function execute(TrackProgressData $data): float
    {
            return DB::transaction(function () use ($data) {
                $course = Course::findOrFail($data->course_id);

                $totalLessons = DB::table('lessons')
                    ->join('modules', 'modules.id', '=', 'lessons.module_id')
                    ->where('modules.course_id', $course->id)
                    ->whereNull('lessons.deleted_at')
                    ->whereNull('modules.deleted_at')
                    ->count();

                $completedLessons = CompletedLesson::where('student_id', $data->student_id)
                    ->whereIn('lesson_id', function($query) use ($course) {
                        $query->select('lessons.id')
                            ->from('lessons')
                            ->join('modules', 'modules.id', '=', 'lessons.module_id')
                            ->where('modules.course_id', $course->id)
                            ->whereNull('lessons.deleted_at')
                            ->whereNull('modules.deleted_at');
                    })
                    ->where('is_completed', true)
                    ->count();

                $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

                $progress = round($progress, 2);

                $enrollment = Enrollment::where([
                    'course_id' => $data->course_id,
                    'student_id' => $data->student_id,
                ])->first();

                $wasCompleted = $enrollment && $enrollment->completed_at !== null;
                $isNowCompleted = $progress >= 100;
                $completed_at = $wasCompleted ? $enrollment->completed_at : ($isNowCompleted ? now() : null);

                $enrollment = Enrollment::updateOrCreate(
                    [
                        'course_id' => $data->course_id,
                        'student_id' => $data->student_id,
                    ],
                    [
                        'progress' => $progress,
                        'completed_at' => $completed_at,
                        'last_progress_update' => now(),
                    ]
                );

                try {
                    activity()
                        ->causedBy($this->student_id ? \App\Models\Student::find($this->student_id) : null)
                        ->performedOn($course)
                        ->withProperties([
                            'course_id' => $data->course_id,
                            'progress' => $progress,
                            'total_lessons' => $totalLessons,
                            'completed_lessons' => $completedLessons
                        ])
                        ->log('course progress updated');

                    if ($isNowCompleted && !$wasCompleted) {
                        activity()
                            ->causedBy($this->student_id ? \App\Models\Student::find($this->student_id) : null)
                            ->performedOn($course)
                            ->withProperties(['course_id' => $data->course_id])
                            ->log('course completed');
                    }
                } catch (\Throwable $e) {
                    Log::warning('Activity log failed: ' . $e->getMessage());
                }

                return $progress;
            });
    }
}
