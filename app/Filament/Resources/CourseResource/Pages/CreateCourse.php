<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
// use Filament\Resources\Form;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
    public  function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('description')->required(),
                 TextInput::make('slug')->required(),
               FileUpload::make('image')
                    ->image()
                    ->openable()
                    ->disk('courses')
                    ->visibility('public') // Set visibility during upload
                    ->uploadingMessage('Uploading image please wait...')
                    ->imagePreviewHeight('250'),
            ]);
    }
}
