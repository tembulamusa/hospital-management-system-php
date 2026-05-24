<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Schemas\PatientPaymentForm;
use App\Filament\Support\FullPageModal;
use App\Filament\Support\PaymentStatus;
use App\Filament\Tables\HospitalTable;
use App\Models\Payment;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\ValidationException;

class PatientPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Receive payment';

    protected static ?string $modelLabel = 'payment';

    public function form(Schema $schema): Schema
    {
        return PatientPaymentForm::configure($schema, $this->getOwnerRecord());
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('paid_at', 'desc')
            ->columns([
                TextColumn::make('paid_at')
                    ->label('Paid at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('billing.visit.visit_number')
                    ->label('Visit invoice')
                    ->placeholder('—'),
                TextColumn::make('billing.status')
                    ->label('Invoice status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => PaymentStatus::label($state))
                    ->color(fn (string $state): string => PaymentStatus::color($state)),
                TextColumn::make('amount')
                    ->label('Received')
                    ->money('KES')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge(),
                TextColumn::make('reference')
                    ->searchable(),
                TextColumn::make('notes')
                    ->limit(40)
                    ->toggleable(),
            ])
            ->filters([
                ...HospitalTable::archiveFilters(),
            ])
            ->headerActions([
                FullPageModal::configureCreate(
                    CreateAction::make()
                        ->label('Receive payment')
                        ->modalHeading('Receive payment')
                        ->using(function (array $data): Payment {
                            $patient = $this->getOwnerRecord();

                            if (! PatientPaymentForm::billingBelongsToPatient((int) $data['billing_id'], $patient)) {
                                throw ValidationException::withMessages([
                                    'billing_id' => 'The selected invoice does not belong to this patient.',
                                ]);
                            }

                            $billing = $patient->billings()->findOrFail($data['billing_id']);

                            if ((float) $data['amount'] > (float) $billing->balance) {
                                throw ValidationException::withMessages([
                                    'amount' => 'Amount cannot exceed the invoice balance of KES ' . number_format((float) $billing->balance, 2) . '.',
                                ]);
                            }

                            return Payment::query()->create($data);
                        }),
                ),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
