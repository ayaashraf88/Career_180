<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Form;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\TextInput::make('slug')->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->imageResizeTargetWidth(800)
                    ->imageResizeTargetHeight(600)
                    ->openable()
                    ->previewable()
                    ->disk('courses')
                    ->visibility('public')
                    ->uploadingMessage('Uploading image please wait...'),

            ]);
    }
}
