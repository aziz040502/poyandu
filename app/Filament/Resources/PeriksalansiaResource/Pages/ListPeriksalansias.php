<?php

namespace App\Filament\Resources\PeriksalansiaResource\Pages;

use App\Filament\Resources\PeriksalansiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriksalansias extends ListRecords
{
    protected static string $resource = PeriksalansiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
