<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Filament\Schemas\PatientPaymentFormSection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient Profile')
                    ->schema([
                        TextInput::make('patient_number')
                            ->label('Patient Number')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Auto-generated on save'),
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('date_of_birth'),
                        Select::make('gender')
                            ->required()
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                                'Other' => 'Other',
                            ]),
                        TextInput::make('phone')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Textarea::make('address')
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('blood_group')
                            ->options([
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                                'O+' => 'O+',
                                'O-' => 'O-',
                            ]),
                        TextInput::make('insurance_provider')
                            ->maxLength(255),
                        TextInput::make('insurance_number')
                            ->maxLength(255),
                        FileUpload::make('photo')
                            ->image()
                            ->directory('patients'),
                    ])
                    ->columns(2),
                ...PatientPaymentFormSection::make(),
            ]);
    }
}
