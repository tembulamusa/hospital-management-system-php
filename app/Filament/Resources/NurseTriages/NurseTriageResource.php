<?php

namespace App\Filament\Resources\NurseTriages;

use App\Filament\Resources\NurseTriages\Pages\CreateNurseTriage;
use App\Filament\Resources\NurseTriages\Pages\EditNurseTriage;
use App\Filament\Resources\NurseTriages\Pages\ListNurseTriages;
use App\Filament\Resources\NurseTriages\Pages\ViewNurseTriage;
use App\Filament\Resources\NurseTriages\Schemas\NurseTriageForm;
use App\Filament\Resources\NurseTriages\Schemas\NurseTriageInfolist;
use App\Filament\Resources\NurseTriages\Tables\NurseTriagesTable;
use App\Models\NurseTriage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NurseTriageResource extends Resource
{
    protected static ?string $model = NurseTriage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboard;
    protected static UnitEnum|string|null $navigationGroup = 'Clinical Workflow';
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'visit_id';

    public static function form(Schema $schema): Schema
    {
        return NurseTriageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NurseTriageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NurseTriagesTable::configure($table);
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
            'index' => ListNurseTriages::route('/'),
            'create' => CreateNurseTriage::route('/create'),
            'view' => ViewNurseTriage::route('/{record}'),
            'edit' => EditNurseTriage::route('/{record}/edit'),
        ];
    }
}
