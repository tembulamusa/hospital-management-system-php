<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Resources\Billings\Schemas\BillingForm;
use App\Filament\Resources\Billings\Tables\BillingsTable;
use App\Filament\Support\FullPageModal;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BillingsRelationManager extends RelationManager
{
    protected static string $relationship = 'billings';

    protected static ?string $title = 'Billing & payments';

    public function form(Schema $schema): Schema
    {
        return BillingForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return BillingsTable::configure($table)
            ->headerActions([
                FullPageModal::configureCreate(CreateAction::make()),
            ]);
    }
}
