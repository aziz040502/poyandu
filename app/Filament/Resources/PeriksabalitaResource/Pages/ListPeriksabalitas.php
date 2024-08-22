<?php

namespace App\Filament\Resources\PeriksabalitaResource\Pages;

use Filament\Tables;
use Filament\Actions;
use Tables\TableFooter;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PeriksabalitaResource;

class ListPeriksabalitas extends ListRecords
{
    protected static string $resource = PeriksabalitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }


    public static function getWidgets(): array
    {
        return [
            // PeriksabalitaResource\Widgets\keterangan::class,
            PeriksabalitaResource\Widgets\datastuntingChart::class,
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            // PeriksabalitaResource\Widgets\keterangan::class,
            PeriksabalitaResource\Widgets\datastuntingChart::class,
        ];
    }
    public function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }
}
