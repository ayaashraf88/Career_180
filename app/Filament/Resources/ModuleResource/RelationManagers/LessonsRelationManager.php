<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'Lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('video_url')
                    ->label('Add Video url instead of uploading it')
                    ->maxLength(255),
                Forms\Components\TextInput::make('content')
                    ->maxLength(255),
                Forms\Components\TextInput::make('duration')
                    ->label('Duraion in minutes')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('video_url')->label('Video URL'),
                Tables\Columns\TextColumn::make('content')->searchable(),
                Tables\Columns\TextColumn::make('duration')->label('Duraion in minutes')->searchable(),
                Tables\Columns\TextColumn::make('price')->money('egp', true),
                IconColumn::make('visible')
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('Visible')
                    ->action(function (Lesson $record) {
                        $record->visible = true;
                        $record->save();
                    })->hidden(fn(Lesson $record): bool => $record->visible),
                Action::make('unvisible')
                    ->action(function (Lesson $record) {
                        $record->visible = false;
                        $record->save();
                    })->visible(fn(Lesson $record): bool => $record->visible),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
