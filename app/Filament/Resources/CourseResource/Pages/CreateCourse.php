<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Models\Course;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
// use Filament\Resources\Form;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;
use Closure;
use Filament\Notifications\Notification;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
    protected function beforeCreate(): void
    {
        $data = $this->form->getState();
        $activeExists = Course::where('slug', $data['slug'])
            ->whereNull('deleted_at')
            ->exists();
        $trashedExists = Course::onlyTrashed()
            ->where('slug', $data['slug'])
            ->exists();

        if ($activeExists) {
            Notification::make()
                ->title('Slug already in use')
                ->body('This slug is already used by an active course.')
                ->danger()
                ->send();

            $this->halt();
        }

        if ($trashedExists) {
            Notification::make()
                ->title('Slug was previously used')
                ->body('This slug was used by a deleted course. Please choose a different one.')
                ->warning()
                ->send();

            $this->halt();
        }
    }
    public  function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')->required(),
                TextInput::make('description')->required(),
                TextInput::make('slug')->required()
                // ->unique(
                //     ignoreRecord: true,
                //     table: Course::class,
                //     column: 'slug',
                //     modifyRuleUsing: function (Unique $rule) {
                //         return $rule->whereNotNull('deleted_at');
                //     },

                // )
                ,
                FileUpload::make('image')
                    ->image()
                    ->imageResizeTargetWidth(800) // Resizes to 800 pixels wide
                    ->imageResizeTargetHeight(600)
                    ->openable()
                    ->disk('courses')
                    ->visibility('public') // Set visibility during upload
                    ->uploadingMessage('Uploading image please wait...')
                    ->imagePreviewHeight('250'),
            ]);
    }
}
