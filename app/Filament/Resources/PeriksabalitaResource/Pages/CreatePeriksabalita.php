<?php

namespace App\Filament\Resources\PeriksabalitaResource\Pages;

use App\Filament\Resources\PeriksabalitaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeriksabalita extends CreateRecord
{
    protected static string $resource = PeriksabalitaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
