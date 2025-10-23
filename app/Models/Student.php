<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\CompletedLesson;

class Student extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verified_at',
    ];
    protected $dates = ['deleted_at', 'verified_at'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected static $logAttributes = ['name', 'email'];
    protected static $logOnlyDirty = true;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verified_at' => 'datetime',
        ];
    }
    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
    public function Courses()
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'id');
    }

    /**
     * Relation: completed lessons for this student
     */
    public function completedLessons()
    {
        return $this->hasMany(CompletedLesson::class, 'student_id', 'id');
    }

 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

}
