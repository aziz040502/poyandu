<?php

namespace App\Filament\Widgets;

use App\models\balita;
use App\Models\ibuhamil;
use App\Models\lansia;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '5s';
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah balita', balita::count())
                ->description('Jumlah data balita')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([1, 3, 5, 10, 20, 40])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ])
                ->color('success'),
            Stat::make('Jumlah ibu hamil', ibuhamil::count())
                ->description('Jumlah data ibu hamil')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([1, 3, 5, 10, 20, 40])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ])
                ->color('info'),
            Stat::make('Jumlah lansia', lansia::count())
                ->description('Jumlah data lansia')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([1, 3, 5, 10, 20, 40])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ])
                ->color('warning'),
        ];
    }
}
