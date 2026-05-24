<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Permission')
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
