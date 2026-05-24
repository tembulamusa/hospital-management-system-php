<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema, ?string $fixedRole = null, bool $showRoleField = true): Schema
    {
        return $schema
            ->components([
                Section::make('Staff Profile')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('employee_number')
                            ->label('Employee Number')
                            ->maxLength(255),
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                                'Other' => 'Other',
                            ]),
                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth'),
                        TextInput::make('specialization')
                            ->label('Specialization')
                            ->maxLength(255)
                            ->helperText('Primary clinical or job specialty'),
                        Textarea::make('qualifications')
                            ->label('Qualifications')
                            ->rows(3)
                            ->helperText('Degrees, certifications, and professional credentials')
                            ->columnSpanFull(),
                        Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->default($fixedRole ? [$fixedRole] : null)
                            ->hidden(filled($fixedRole) || ! $showRoleField)
                            ->dehydrated(filled($fixedRole) || $showRoleField),
                        Toggle::make('active')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
