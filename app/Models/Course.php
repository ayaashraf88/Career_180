<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use SoftDeletes,HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'slug'
    ];
    protected $dates = ['deleted_at'];
    // function Students()
    // {
    //     return $this->hasMany(Enrollment::class, 'course_id', 'id');
    // }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'id');
    }
    function Modules()
    {
        return $this->hasMany(Module::class, 'course_id', 'id');
    }
    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class, 'course_id', 'module_id');
    }
    public function getTotalLessonsAttribute(): int
    {
        return $this->lessons()->count();
    }
    function calculateTotalDuration(): int
    {
        return $this->lessons()->sum('duration');
    }
    public function getFormattedTotalDurationAttribute(): string
    {
        $totalMinutes = $this->calculateTotalDuration();
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }
    
}
