<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompletedLesson extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'lesson_id',
        'student_id',
        'is_completed',
        'completed_at',
    ];
    protected $dates = ['completed_at', 'deleted_at'];
    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];
    protected $table = 'completed_lessons';
    function Student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    function Lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }
}
