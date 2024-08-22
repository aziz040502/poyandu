<?php

namespace App\Filament\Resources\IbuHamilResource\Pages;

use App\Filament\Resources\IbuHamilResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIbuHamil extends CreateRecord
{
    protected static string $resource = IbuHamilResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
