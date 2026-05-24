<?php

namespace App\Filament\Resources\Patients;

use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Filament\Resources\Patients\Pages\ViewPatient;
use App\Filament\Resources\Patients\Schemas\PatientForm;
use App\Filament\Resources\Patients\Schemas\PatientInfolist;
use App\Filament\Resources\Patients\Tables\PatientsTable;
use App\Filament\Resources\Patients\RelationManagers\BillingsRelationManager;
use App\Filament\Resources\Patients\RelationManagers\MedicalHistoriesRelationManager;
use App\Filament\Resources\Patients\RelationManagers\PatientPaymentsRelationManager;
use App\Models\Patient;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static UnitEnum|string|null $navigationGroup = 'Patient Management';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'patient_number';

    public static function form(Schema $schema): Schema
    {
        return PatientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PatientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientsTable::configure($table);
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with([
            'billings',
            'payments.billing.visit',
            'medicalHistories.recordedBy',
            'nurseTriages.visit',
            'nurseTriages.nurse',
            'doctorNotes.visit',
            'prescriptions.visit',
            'prescriptions.doctor',
            'prescriptions.items.medicine',
        ]);
    }

    public static function getRelations(): array
    {
        return [
            MedicalHistoriesRelationManager::class,
            PatientPaymentsRelationManager::class,
            BillingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'view' => ViewPatient::route('/{record}'),
        ];
    }
}
