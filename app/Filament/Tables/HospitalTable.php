<?php

namespace App\Filament\Tables;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class HospitalTable
{
    /**
     * @return array<SelectFilter>
     */
    public static function archiveFilters(): array
    {
        return [
            SelectFilter::make('archive_status')
                ->label('Records')
                ->options([
                    'active' => 'Active',
                    'archived' => 'Archived',
                    'all' => 'All',
                ])
                ->default('active')
                ->query(function (Builder $query, array $data): Builder {
                    return match ($data['value'] ?? 'active') {
                        'archived' => $query->onlyTrashed(),
                        'all' => $query->withTrashed(),
                        default => $query->withoutTrashed(),
                    };
                }),
        ];
    }
}
