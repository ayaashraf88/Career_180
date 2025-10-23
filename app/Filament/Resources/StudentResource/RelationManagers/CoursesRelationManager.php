<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\CompletedLesson;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\StudentResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'Courses';
    protected static ?string $title = 'Enrolled Courses';
    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('course_id')
    //                 ->required()
    //                 ->maxLength(255),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
             
            ->recordTitleAttribute('course_id')
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course Name')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('progress')
                    ->label('Progress')
                    ->formatStateUsing(fn($state) => ($state !== null ? round($state) . '%' : '0%')),
             
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([

                Tables\Actions\DeleteAction::make()->label('Unenroll'),
                Tables\Actions\RestoreAction::make(),
                // Tables\Actions\Action::make('viewLessons')
                //     ->label('View Lessons')
                //     ->icon('heroicon-o-eye'),
                    // ->url(fn(Model $record): string => route('filament.resources.student-resource.pages.view-lessons', [
                    //     'student' => $this->ownerRecord->id,
                    //     'course' => $record->course_id,
                    // ]))->color('primary'),
            ]);
    }
}
