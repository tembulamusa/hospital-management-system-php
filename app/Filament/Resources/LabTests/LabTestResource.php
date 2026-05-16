<?php

namespace App\Filament\Resources\LabTests;

use App\Filament\Resources\LabTests\Pages\CreateLabTest;
use App\Filament\Resources\LabTests\Pages\EditLabTest;
use App\Filament\Resources\LabTests\Pages\ListLabTests;
use App\Filament\Resources\LabTests\Pages\ViewLabTest;
use App\Filament\Resources\LabTests\Schemas\LabTestForm;
use App\Filament\Resources\LabTests\Schemas\LabTestInfolist;
use App\Filament\Resources\LabTests\Tables\LabTestsTable;
use App\Models\LabTest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LabTestResource extends Resource
{
    protected static ?string $model = LabTest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;
    protected static UnitEnum|string|null $navigationGroup = 'Laboratory';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LabTestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LabTestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LabTestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLabTests::route('/'),
            'create' => CreateLabTest::route('/create'),
            'view' => ViewLabTest::route('/{record}'),
            'edit' => EditLabTest::route('/{record}/edit'),
        ];
    }
}
