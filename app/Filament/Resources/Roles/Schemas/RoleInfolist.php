<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('guard_name'),
                    ])
                    ->columns(2),
            ]);
    }
}
