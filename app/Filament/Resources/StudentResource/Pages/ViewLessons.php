<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\Page;
use App\Models\Student;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CompletedLesson;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ViewLessons extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = StudentResource::class;
    // protected static ?string $route = '/{student}/view-lessons/{course}';
    protected static string $view = 'filament.resources.student-resource.pages.view-lessons';

    public Student $student;
    public Course $course;

    /**
     * @param Student|int|null $student
     * @param Course|int|null $course
     */
    public function mount($student = null, $course = null): void
    {
        $this->student = $student instanceof Student ? $student : Student::find($student);
        $this->course = $course instanceof Course ? $course : Course::find($course);
    }
    public function table($table)
    {
        if ($table instanceof \Filament\Infolists\Infolist) {
            return $table;
        }

        if ($table instanceof Table) {
            $studentId = $this->student->id;
            $courseId = $this->course->id;
            return $table
                ->query(
                    Lesson::query()
                        ->whereHas('module', fn($q) => $q->where('course_id', $courseId))
                        ->with('module')
                        ->select('lessons.*')
                        ->selectRaw("
                            CASE WHEN lessons.id IN (
                                SELECT lesson_id FROM completed_lessons WHERE student_id = ?
                            ) THEN 'Watched' ELSE 'Unwatched' END as watched
                        ", [$studentId])
                )
                ->columns([
                    TextColumn::make('id')->label('#')->sortable(),
                    TextColumn::make('title')->label('Lesson')->searchable()->sortable(),
                    TextColumn::make('module.name')->label('Module'),
                    TextColumn::make('watched')
                        ->label('Status')
                        ->badge()
                        ->colors([
                            'success' => fn($state) => $state === 'Watched',
                            'warning' => fn($state) => $state === 'Unwatched',
                        ]),
                ]);
        }

        return $table;
    }
}
