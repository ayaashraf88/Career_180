<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'verified' => Tab::make('Active Students')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('verified', true)),
            'inverified' => Tab::make('Inactive Students')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('verified', false)),
        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                IconColumn::make('verified')
                    ->boolean(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Action::make('verified')
                    ->action(function (Student $record) {
                        $record->verified = true;
                        $record->verified_at = now();
                        $record->save();
                    })->hidden(fn(Student $record): bool => $record->verified),
                Action::make('unverified')
                    ->action(function (Student $record) {
                        $record->verified = false;
                        $record->verified_at = null;
                        $record->save();
                    })->visible(fn(Student $record): bool => $record->verified),
                EditAction::make(),
                RestoreAction::make(),
            ])->bulkActions([
                DeleteBulkAction::make(),
            ])->recordUrl(null);
    }
}
