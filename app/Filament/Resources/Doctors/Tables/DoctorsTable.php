<?php

namespace App\Filament\Resources\Doctors\Tables;

use App\Filament\Support\FullPageModal;
use App\Filament\Tables\HospitalTable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable(),
                TextColumn::make('employee_number')
                    ->label('Employee No.')
                    ->searchable(),
                TextColumn::make('specialization')
                    ->searchable(),
                TextColumn::make('qualifications')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('phone')
                    ->toggleable(),
                IconColumn::make('active')
                    ->boolean(),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
                TernaryFilter::make('active'),
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
