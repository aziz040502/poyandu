<?php

namespace App\Filament\Resources\PeriksaibuhamilResource\Pages;

use App\Filament\Resources\PeriksaibuhamilResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriksaibuhamils extends ListRecords
{
    protected static string $resource = PeriksaibuhamilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
