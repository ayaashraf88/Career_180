<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'video_url',
        'order',
        'visible',
        'duration'
    ];
     protected $dates = ['deleted_at'];
    function Module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
