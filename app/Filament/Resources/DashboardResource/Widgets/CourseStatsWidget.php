<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Course;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CourseStatsWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $coursesWithContent = Course::has('modules')->count();
        $avgModulesPerCourse = Course::withCount('modules')->get()->avg('modules_count') ?? 0;
        return [
            'labels' => ['Courses with Content', 'Avg Modules per Course'],
            'datasets' => [
                [
                    'label' => 'Course Statistics',
                    'data' => [$coursesWithContent, round($avgModulesPerCourse, 2)],
                    'backgroundColor' => ['#3B82F6', '#10B981', '#F59E0B'],
                ],
            ],

        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
