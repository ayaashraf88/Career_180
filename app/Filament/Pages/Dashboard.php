<?php

namespace App\Filament\Pages;

use App\Filament\Resources\DashboardResource\Widgets\CourseStatsWidget;
use App\Filament\Resources\DashboardResource\Widgets\EducationStatsOverview;
use App\Filament\Resources\DashboardResource\Widgets\StudentRegistrationChart;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';
    protected static ?int $navigationSort = -2;
    protected function getWidgets(): array
    {
        return [
            EducationStatsOverview::class,
            CourseStatsWidget::class,
            StudentRegistrationChart::class,
        ];
    }
}
