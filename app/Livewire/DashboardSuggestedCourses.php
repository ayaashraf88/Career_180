<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class DashboardSuggestedCourses extends Component
{
    public $randomCourses = [];
    function mount()
    {
        $this->randomCourses = $this->getRandomCourses();
    }
    public function getRandomCourses()
    {
        try {
            if (!auth()->guard('student')->check()) {
                $availableCourseIds = Course::pluck('id')->toArray();
                    $randomCourses = Course::whereIn('id', $availableCourseIds)
                ->inRandomOrder()
                ->limit(5)
                ->get();
            }else{
            $student = auth()->guard('student')->user();
            $availableCourseIds = $student->Courses()->pluck('course_id')->toArray();
                $randomCourses = Course::whereNotIn('id', $availableCourseIds)
                ->inRandomOrder()
                ->limit(5)
                ->get();
            }
        
            return $randomCourses;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors(['error' => $e->errors()]);
        }
    }
    public function render()
    {
        return view('livewire.dashboard-suggested-courses');
    }
}
