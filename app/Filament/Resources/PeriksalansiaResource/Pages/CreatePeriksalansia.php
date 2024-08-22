<?php

namespace App\Filament\Resources\PeriksalansiaResource\Pages;

use App\Filament\Resources\PeriksalansiaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeriksalansia extends CreateRecord
{
    protected static ?string $title = ' tambah pemeriksa lansia';
    protected static string $resource = PeriksalansiaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
