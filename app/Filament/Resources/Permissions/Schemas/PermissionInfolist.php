<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PermissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Permission')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('guard_name'),
                    ])
                    ->columns(2),
            ]);
    }
}
