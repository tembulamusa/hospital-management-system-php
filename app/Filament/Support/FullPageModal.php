<?php

namespace App\Filament\Support;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\Width;

class FullPageModal
{
    public static function create(): CreateAction
    {
        return static::configureCreate(CreateAction::make());
    }

    public static function configureCreate(CreateAction $action): CreateAction
    {
        return $action->modalWidth(Width::Screen);
    }

    public static function edit(): EditAction
    {
        return static::configureEdit(EditAction::make());
    }

    public static function configureEdit(EditAction $action): EditAction
    {
        return $action->modalWidth(Width::Screen);
    }
}
