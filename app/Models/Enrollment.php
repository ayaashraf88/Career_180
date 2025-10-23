<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Enrollment extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
        'progress',
        'completed_at'
    ];
    
    protected $casts = [
        'completed_at' => 'datetime',
        'deleted_at' => 'datetime',
        'progress' => 'float'
    ];
    function Student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    function Course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    function calculateProgress($studentId, $course_id)
    {

        $totalLessons = DB::table('lessons')
            ->join('modules', 'modules.id', '=', 'lessons.module_id')
            ->where('modules.course_id', $course_id)
            ->whereNull('lessons.deleted_at')
            ->whereNull('modules.deleted_at')
            ->count();

        $completedLessons = CompletedLesson::where('student_id', $studentId)
            ->whereIn('lesson_id', function ($query) use ($course_id) {
                $query->select('lessons.id')
                    ->from('lessons')
                    ->join('modules', 'modules.id', '=', 'lessons.module_id')
                    ->where('modules.course_id', $course_id)
                    ->whereNull('lessons.deleted_at')
                    ->whereNull('modules.deleted_at');
            })
            ->where('is_completed', true)
            ->count();

        $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

        // $progress = round($progress, 2);
        return $progress;
    }
}
