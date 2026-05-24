<?php

namespace App\Filament\Resources\Appointments\Tables;

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

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.patient_number')
                    ->label('Patient')
                    ->searchable(),
                TextColumn::make('patient.payment_status')
                    ->label('Payment')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => PaymentStatus::label($state ?? PaymentStatus::NO_BILLING))
                    ->color(fn (?string $state): string => PaymentStatus::color($state ?? PaymentStatus::NO_BILLING)),
                TextColumn::make('patient.outstanding_balance')
                    ->label('Balance due')
                    ->money('KES')
                    ->color(fn ($record): string => ($record->patient?->outstanding_balance ?? 0) > 0 ? 'danger' : 'success'),
                TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->searchable(),
                TextColumn::make('appointment_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
                SelectFilter::make('payment_status')
                    ->label('Patient payment')
                    ->options(PaymentStatus::labels())
                    ->query(fn ($query, array $data) => filled($data['value'] ?? null)
                        ? $query->whereHas('patient', fn ($q) => $q->wherePaymentStatus($data['value']))
                        : $query),
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
