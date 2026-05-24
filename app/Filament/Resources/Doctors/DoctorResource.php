<?php

namespace App\Filament\Resources\Doctors;

use App\Filament\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Resources\Doctors\Pages\ViewDoctor;
use App\Filament\Resources\Doctors\Tables\DoctorsTable;
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

class DoctorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Doctor';

    protected static ?string $pluralModelLabel = 'Doctors';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static UnitEnum|string|null $navigationGroup = 'Setup';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'doctors';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->role('Doctor');
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema, fixedRole: 'Doctor', showRoleField: false);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDoctors::route('/'),
            'view' => ViewDoctor::route('/{record}'),
        ];
    }
}
