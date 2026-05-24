<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Schemas\MedicalHistoryForm;
use App\Filament\Support\FullPageModal;
use App\Filament\Tables\HospitalTable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MedicalHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'medicalHistories';

    protected static ?string $title = 'Medical history';

    public function form(Schema $schema): Schema
    {
        return MedicalHistoryForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('recorded_at', 'desc')
            ->columns([
                TextColumn::make('recorded_at')
                    ->label('Recorded at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('recordedBy.name')
                    ->label('Recorded by')
                    ->placeholder('—'),
                TextColumn::make('presenting_complaint')
                    ->label('Presenting complaint')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('allergies')
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('past_medical_history')
                    ->label('Past medical history')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
            ])
            ->headerActions([
                FullPageModal::configureCreate(CreateAction::make()),
            ])
            ->recordActions([
                FullPageModal::edit(),
                DeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
