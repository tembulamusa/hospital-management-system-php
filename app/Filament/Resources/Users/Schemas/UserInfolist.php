<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Staff Profile')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('roles.name')
                            ->label('Roles')
                            ->badge()
                            ->separator(', '),
                        TextEntry::make('department.name')
                            ->label('Department'),
                        TextEntry::make('employee_number')
                            ->label('Employee Number'),
                        TextEntry::make('phone'),
                        TextEntry::make('gender'),
                        TextEntry::make('date_of_birth')
                            ->date(),
                        TextEntry::make('specialization'),
                        TextEntry::make('qualifications')
                            ->columnSpanFull(),
                        IconEntry::make('active')
                            ->boolean(),
                    ])
                    ->columns(2),
            ]);
    }
}
