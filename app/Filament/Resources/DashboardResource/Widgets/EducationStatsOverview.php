<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EducationStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
         $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalModules = Module::count();
        $totalLessons = Lesson::count();
        return [
           Stat::make('Total Students', $totalStudents)
                ->description('Registered learners')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->url(route('filament.admin.resources.students.index')),
                 Stat::make('Total Courses', $totalCourses)
                ->description('Available courses')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success')
                ->url(route('filament.admin.resources.courses.index')),
        ];
    }
}
