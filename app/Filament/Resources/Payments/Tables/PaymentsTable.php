<?php

namespace App\Filament\Resources\Payments\Tables;

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
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('billing.patient.patient_number')
                    ->label('Patient')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('billing.patient.first_name')
                    ->label('First name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('billing.patient.last_name')
                    ->label('Last name')
                    ->searchable(),
                TextColumn::make('billing.status')
                    ->label('Invoice status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => PaymentStatus::label($state))
                    ->color(fn (string $state): string => PaymentStatus::color($state)),
                TextColumn::make('paid_at')
                    ->label('Paid at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('KES')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge(),
                TextColumn::make('reference')
                    ->searchable()
                    ->toggleable(),
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
