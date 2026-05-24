<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Support\FullPageModal;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

abstract class ListRecords extends \Filament\Resources\Pages\ListRecords
{
    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::create(),
        ];
    }

    public function getDefaultActionUrl(Action $action): ?string
    {
        if ($action instanceof CreateAction || $action instanceof EditAction) {
            return null;
        }

        return parent::getDefaultActionUrl($action);
    }

    public function getDefaultActionSchemaResolver(Action $action): ?Closure
    {
        return match (true) {
            $action instanceof CreateAction, $action instanceof EditAction => fn (Schema $schema): Schema => $this->form(
                $schema->hasCustomColumns() ? $schema : $schema->columns(3),
            ),
            $action instanceof ViewAction => fn (Schema $schema): Schema => $this->infolist(
                $this->form($schema->hasCustomColumns() ? $schema : $schema->columns(3)),
            ),
            default => parent::getDefaultActionSchemaResolver($action),
        };
    }

    protected function makeTable(): Table
    {
        return parent::makeTable()->poll('30s');
    }
}
