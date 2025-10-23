<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'course_id',
        'name',
        'order'
    ];
    protected $dates = ['deleted_at'];
    function lessons()
    {
        return $this->hasMany(Lesson::class, 'module_id', 'id');
    }
    function Course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
