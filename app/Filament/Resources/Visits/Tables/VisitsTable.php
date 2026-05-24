<?php

namespace App\Filament\Resources\Visits\Tables;

use App\Filament\Support\FullPageModal;
use App\Filament\Support\PaymentStatus;
use App\Filament\Tables\HospitalTable;
use App\Models\Visit;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('visit_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.patient_number')
                    ->label('Patient')
                    ->searchable(),
                TextColumn::make('patient.payment_status')
                    ->label('Patient payment')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => PaymentStatus::label($state ?? PaymentStatus::NO_BILLING))
                    ->color(fn (?string $state): string => PaymentStatus::color($state ?? PaymentStatus::NO_BILLING)),
                TextColumn::make('billing.status')
                    ->label('Visit invoice')
                    ->badge()
                    ->placeholder('No invoice')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? PaymentStatus::label($state) : 'No invoice')
                    ->color(fn (?string $state): string => PaymentStatus::color($state ?? PaymentStatus::NO_BILLING)),
                TextColumn::make('billing.balance')
                    ->label('Visit balance')
                    ->money('KES')
                    ->placeholder('—')
                    ->color(fn (Visit $record): string => ($record->billing?->balance ?? 0) > 0 ? 'danger' : 'success'),
                TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
                SelectFilter::make('billing_status')
                    ->label('Visit payment')
                    ->options(PaymentStatus::billingLabels())
                    ->query(function ($query, array $data) {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas('billing', fn ($q) => $q->where('status', $data['value']));
                    }),
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
