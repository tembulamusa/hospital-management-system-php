<?php

namespace App\Filament\Resources\NurseTriages\Tables;

use App\Filament\Support\FullPageModal;
use App\Filament\Tables\HospitalTable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NurseTriagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('visit.visit_number')
                    ->label('Visit')
                    ->searchable(),
                TextColumn::make('nurse.name')
                    ->label('Nurse')
                    ->searchable(),
                TextColumn::make('temperature'),
                TextColumn::make('blood_pressure_systolic'),
                TextColumn::make('blood_pressure_diastolic'),
                TextColumn::make('pulse_rate'),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
            ])
            ->recordActions([
                ViewAction::make(),
                FullPageModal::edit(),
                DeleteAction::make(),
                RestoreAction::make(),
            ])
            ->recordUrl(null)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
