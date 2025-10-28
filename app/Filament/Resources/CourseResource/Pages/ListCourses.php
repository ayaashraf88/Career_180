<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('slug')->searchable()->sortable(),
                ImageColumn::make('image')
                    ->state(function ($record) {
                        return url('/uploads/courses/' . $record->image);
                    })
                    ->circular(),
                TextColumn::make('total_lessons')
                    ->label('Total Lessons')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('formatted_total_duration')
                    ->label('Total Duration')
                    ->sortable(['total_duration']),
                TextColumn::make('enrollments_count')
                    ->label('Enrollments')
                    ->counts('enrollments')
                    ->sortable(),
            ])->filters([
                TrashedFilter::make(),
            ])->actions([
                DeleteAction::make(),
                RestoreAction::make(),
            ]);
    }
}
