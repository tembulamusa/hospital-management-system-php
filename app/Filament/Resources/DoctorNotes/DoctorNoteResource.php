<?php

namespace App\Filament\Resources\DoctorNotes;

use App\Filament\Resources\DoctorNotes\Pages\CreateDoctorNote;
use App\Filament\Resources\DoctorNotes\Pages\EditDoctorNote;
use App\Filament\Resources\DoctorNotes\Pages\ListDoctorNotes;
use App\Filament\Resources\DoctorNotes\Pages\ViewDoctorNote;
use App\Filament\Resources\DoctorNotes\Schemas\DoctorNoteForm;
use App\Filament\Resources\DoctorNotes\Schemas\DoctorNoteInfolist;
use App\Filament\Resources\DoctorNotes\Tables\DoctorNotesTable;
use App\Models\DoctorNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DoctorNoteResource extends Resource
{
    protected static ?string $model = DoctorNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocument;
    protected static UnitEnum|string|null $navigationGroup = 'Clinical Workflow';
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'visit_id';

    public static function form(Schema $schema): Schema
    {
        return DoctorNoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DoctorNoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorNotesTable::configure($table);
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
            'index' => ListDoctorNotes::route('/'),
            'create' => CreateDoctorNote::route('/create'),
            'view' => ViewDoctorNote::route('/{record}'),
            'edit' => EditDoctorNote::route('/{record}/edit'),
        ];
    }
}
