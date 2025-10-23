<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\StudentResource\Pages\ViewLessons;

// This file is loaded by Filament and is already under the admin prefix & middleware.
Route::get('/students/{record}/view-lessons/{course}', ViewLessons::class)
    ->name('filament.resources.students.view-lessons');
