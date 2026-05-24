<?php

namespace App\Filament\Resources\Billings\Tables;

use App\Filament\Support\FullPageModal;
use App\Filament\Support\PaymentStatus;
use App\Filament\Tables\HospitalTable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BillingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.patient_number')
                    ->label('Patient no.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.first_name')
                    ->label('First name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('patient.last_name')
                    ->label('Last name')
                    ->searchable(),
                TextColumn::make('visit.visit_number')
                    ->label('Visit')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('KES')
                    ->sortable(),
                TextColumn::make('paid_amount')
                    ->label('Paid')
                    ->money('KES')
                    ->sortable(),
                TextColumn::make('balance')
                    ->label('Balance')
                    ->money('KES')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Payment status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => PaymentStatus::label($state))
                    ->color(fn (string $state): string => PaymentStatus::color($state)),
                TextColumn::make('updated_at')
                    ->label('Last updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
                SelectFilter::make('status')
                    ->label('Payment status')
                    ->options(PaymentStatus::billingLabels()),
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
