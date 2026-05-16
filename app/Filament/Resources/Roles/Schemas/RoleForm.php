<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('guard_name')
                            ->required()
                            ->default('web')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
