<?php

namespace App\Filament\Resources\Patients\Tables;

use App\Filament\Support\PaymentStatus;
use App\Filament\Tables\HospitalTable;
use App\Models\Patient;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient_number')
                    ->label('Patient No.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->state(fn (Patient $record): string => $record->payment_status)
                    ->formatStateUsing(fn (string $state): string => PaymentStatus::label($state))
                    ->color(fn (string $state): string => PaymentStatus::color($state)),
                TextColumn::make('outstanding_balance')
                    ->label('Balance due')
                    ->money('KES')
                    ->state(fn (Patient $record): float => $record->outstanding_balance)
                    ->color(fn (Patient $record): string => $record->outstanding_balance > 0 ? 'danger' : 'success'),
                TextColumn::make('gender'),
                TextColumn::make('phone')
                    ->toggleable(),
                TextColumn::make('blood_group')
                    ->toggleable(),
                ImageColumn::make('photo')
                    ->toggleable(),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
                SelectFilter::make('payment_status')
                    ->label('Payment status')
                    ->options(PaymentStatus::labels())
                    ->query(fn ($query, array $data) => filled($data['value'] ?? null)
                        ? $query->wherePaymentStatus($data['value'])
                        : $query),
            ])
            ->recordActions([
                ViewAction::make(),
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
