<?php

namespace App\Support\Filament;

use App\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class StaffSelect
{
    public static function doctor(string $name = 'doctor_id'): Select
    {
        return Select::make($name)
            ->label('Doctor')
            ->relationship(
                name: str_replace('_id', '', $name),
                titleAttribute: 'name',
                modifyQueryUsing: fn (Builder $query) => $query->role('Doctor')->where('active', true),
            )
            ->searchable()
            ->preload()
            ->required();
    }

    public static function nurse(string $name = 'nurse_id'): Select
    {
        return Select::make($name)
            ->label('Nurse')
            ->options(fn () => User::query()->role('Nurse')->where('active', true)->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->preload();
    }
}
