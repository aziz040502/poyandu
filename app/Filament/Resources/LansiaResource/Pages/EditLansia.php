<?php

namespace App\Filament\Resources\LansiaResource\Pages;

use App\Filament\Resources\LansiaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLansia extends EditRecord
{
    protected static string $resource = LansiaResource::class;

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
