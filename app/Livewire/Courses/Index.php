<?php

namespace App\Livewire\Courses;

use App\Actions\Lesson\MarkAsCompleted;
use App\DTOs\Enrollment\CreateEnrollmentData;
use App\DTOs\Lesson\MarkAsCompletedData;
use App\DTOs\Lesson\TrackProgressData;
use App\Models\CompletedLesson;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Notifications\CourseCompletedNotification;
use App\Notifications\EnrolledNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use function Spatie\Activitylog\activity;

class Index extends Component
{
    public Course $course;
    public $isEnrolled;
    public $addToCart;
    public $totalEnrollments;
    public $selectedModuleId;
    public $selectedLessonId;
    public $buttonText;
    // We'll instantiate the action when needed to avoid container binding issues

    public bool $refreshProgress = false;

    public function mount($slug = null)
    {
        // Load the course by id and ensure modules and lessons are ordered by the `order` column
        $course = Course::where('slug', $slug)->with(['modules' => function ($q) {
            $q->orderBy('order')->with(['lessons' => function ($q2) {
                $q2->orderBy('order');
            }]);
        }])->firstOrFail();

        $this->course = $course;
        // $this->isEnrolled;
        $firstModule = $this->course->modules->first();
        $this->selectedModuleId = $firstModule?->id;
        $this->selectedLessonId = $firstModule?->lessons->first()?->id;
    }
    public function render()
    {
        // $course = $this->course;
        return view('livewire.courses.index', [
            'course' => $this->course,
            'isEnrolled' => $this->checkEnrollment(),
            'totalEnrollments' => $this->getEnrollments(),
            // 'selectModule' => $this->selectModule($this->selectedModuleId),
            // 'selectLesson' => $this->selectLesson($this->selectedLessonId),
        ]);
    }
    private function checkEnrollment()
    {
        if (Auth::guard('student')->check()) {
            $this->isEnrolled = Auth::guard('student')->user()->courses()->where('course_id', $this->course->id)->exists();
        } else {
            $this->isEnrolled = false;
        }

        return $this->isEnrolled;
    }
    public function getEnrollments()
    {
        $this->totalEnrollments = $this->course->enrollments->count();
        return $this->totalEnrollments;
    }
    public function selectModule($moduleId)
    {
        $this->selectedModuleId = $moduleId;

        $module = $this->course->modules->firstWhere('id', $moduleId);

        if ($module && $module->lessons->isNotEmpty()) {
            $this->selectedLessonId = $module->lessons->first()->id;
        } else {
            $this->selectedLessonId = null;
        }
    }
    public function selectLesson($lessonId)
    {
        $this->selectedLessonId = $lessonId;
    }

    /**
     * Return a flat, ordered list of lessons (module order then lesson order)
     * as an array of objects with module and lesson references.
     *
     * @return array<int, array{module: \App\Models\Module, lesson: \App\Models\Lesson}>
     */
    private function getFlattenedLessons(): array
    {
        $flat = [];
        foreach ($this->course->modules->sortBy('order') as $module) {
            foreach ($module->lessons->sortBy('order') as $lesson) {
                $flat[] = ['module' => $module, 'lesson' => $lesson];
            }
        }
        return $flat;
    }

    public function previousLesson()
    {
        $flat = $this->getFlattenedLessons();
        $index = null;
        foreach ($flat as $i => $pair) {
            if ($pair['lesson']->id == $this->selectedLessonId) {
                $index = $i;
                break;
            }
        }

        if ($index === null) return;

        $prevIndex = $index - 1;
        if ($prevIndex >= 0) {
            $this->selectedModuleId = $flat[$prevIndex]['module']->id;
            $this->selectedLessonId = $flat[$prevIndex]['lesson']->id;
        }
    }

    public function nextLesson()
    {
        $flat = $this->getFlattenedLessons();
        $index = null;
        foreach ($flat as $i => $pair) {
            if ($pair['lesson']->id == $this->selectedLessonId) {
                $index = $i;
                break;
            }
        }

        if ($index === null) return;

        $nextIndex = $index + 1;
        if ($nextIndex < count($flat)) {
            $this->selectedModuleId = $flat[$nextIndex]['module']->id;
            $this->selectedLessonId = $flat[$nextIndex]['lesson']->id;
        }
    }

    public function isLessonCompleted($lessonId)
    {
        $studentId = Auth::guard('student')->id();
        if (!$studentId) return false;

        return CompletedLesson::where('lesson_id', $lessonId)
            ->where('student_id', $studentId)
            ->where('is_completed', true)
            ->exists();
    }

    function enroll()
    {
        if(Auth::guard('student')->id()){
     $student = Student::find(Auth::guard('student')->id());
        $request = [
            'course_id' => $this->course->id,
            'student_id' => $student->id,
        ];
        $data = CreateEnrollmentData::fromRequest((object) $request);
        $action = new \App\Actions\Enrollment\CreateEnrollment($data->course_id, $data->student_id);
        $completedLesson = $action->execute($data);
        $this->isEnrolled = true;
        $student->notify(new EnrolledNotification($this->course));
        $this->dispatch('notify', type: 'success', message: 'Congratulations You Enrolled Successfully in this course');
        }else{
                    $this->dispatch('notify', type: 'warning', message: 'You have to log in first to enroll in');

        }
   
    }
    public function markAsCompleted($lessonId, $is_completed)
    {
        try {
            $student_id = Auth::guard('student')->id();
            $request = [
                'lesson_id' => $lessonId,
                'student_id' => $student_id,
                'is_completed' => $is_completed
            ];

            $data = MarkAsCompletedData::fromRequest((object) $request);
            $action = new \App\Actions\Lesson\MarkAsCompleted($data->lesson_id, $data->student_id, $data->is_completed);
            $completedLesson = $action->execute($data);
            // $this->course->refresh();
            $this->dispatch('notify', type: 'success', message: 'Your changes have been saved.');
            $studentId = Auth::guard('student')->id();

            $trackData = [
                'course_id' => $this->course->id,
                'student_id' => $student_id,
            ];

            $data = TrackProgressData::fromRequest((object) $trackData);
            $action = new \App\Actions\Lesson\TrackProgress($data->course_id, $data->student_id);
            $progress = $action->execute($data);
            
            // Force refresh of progress bar
            $this->refreshProgress = !$this->refreshProgress;
            $this->dispatch('progressUpdated');

            $enrollment = Enrollment::where([
                'course_id' => $this->course->id,
                'student_id' => $student_id,
            ])->first();

            if (is_numeric($progress) && $progress >= 100 && 
                (!$enrollment || $enrollment->completed_at === null)) {
                $student = Student::find($studentId);
                if ($student) {
                    $student->notify(new CourseCompletedNotification($this->course));
                    $this->dispatch('notify', type: 'success', message: 'Congratulations! You have completed the course');
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $payload = ['type' => 'error', 'message' => 'Validation failed'];
            $this->dispatch('toasts', type: 'error', message: 'Validation failed');
            $this->dispatch('notify', $payload);
        }
    }
}
