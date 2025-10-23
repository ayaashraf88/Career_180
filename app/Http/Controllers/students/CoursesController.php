<?php

namespace App\Http\Controllers\students;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    function enrolledCourses()
    {
        try {
            $student = auth()->guard('student')->user();
            $enrollments = $student->courses()
                ->whereHas('course')
                ->with('course')
                ->get();
            $enrolledCourses = $enrollments->map(function ($enrollment) {
                $course = $enrollment->course;
                $course->progress = $enrollment->progress ?? 0;
                $course->completed_at = $enrollment->completed_at;
                $course->is_completed = $enrollment->is_completed;
                $course->lessons = $course->getTotalLessonsAttribute();

                return $course;
            });
            return view('students.courses', ['enrolledCourses' => $enrolledCourses]);
        } catch (\Illuminate\Validation\ValidationException  $e) {
            return back()->withErrors(['error' => $e->errors()])->withInput();
        }
    }
}
