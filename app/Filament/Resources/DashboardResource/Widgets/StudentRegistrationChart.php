<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Student;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
class StudentRegistrationChart extends ChartWidget
{
    protected static ?string $heading = 'Student Registrations (Last 30 Days)';

    protected function getData(): array
    {
         $data = Trend::model(Student::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();
        return [
           'datasets' => [
                [
                    'label' => 'Student Registrations',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
