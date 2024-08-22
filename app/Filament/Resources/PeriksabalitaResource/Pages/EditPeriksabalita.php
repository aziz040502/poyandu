<?php

namespace App\Filament\Resources\PeriksabalitaResource\Pages;

use App\Filament\Resources\PeriksabalitaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriksabalita extends EditRecord
{
    protected static string $resource = PeriksabalitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
