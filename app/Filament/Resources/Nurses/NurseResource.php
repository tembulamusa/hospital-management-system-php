<?php

namespace App\Filament\Resources\Nurses;

use App\Filament\Resources\Nurses\Pages\ListNurses;
use App\Filament\Resources\Nurses\Pages\ViewNurse;
use App\Filament\Resources\Nurses\Tables\NursesTable;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class NurseResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Nurse';

    protected static ?string $pluralModelLabel = 'Nurses';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static UnitEnum|string|null $navigationGroup = 'Setup';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'nurses';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->role('Nurse');
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema, fixedRole: 'Nurse', showRoleField: false);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NursesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNurses::route('/'),
            'view' => ViewNurse::route('/{record}'),
        ];
    }
}
