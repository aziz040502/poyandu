<?php

namespace App\Filament\Resources\PeriksalansiaResource\Pages;

use App\Filament\Resources\PeriksalansiaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriksalansia extends EditRecord
{
    protected static string $resource = PeriksalansiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
