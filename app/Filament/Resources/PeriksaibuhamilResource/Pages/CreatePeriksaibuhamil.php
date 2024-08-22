<?php

namespace App\Filament\Resources\PeriksaibuhamilResource\Pages;

use App\Filament\Resources\PeriksaibuhamilResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeriksaibuhamil extends CreateRecord
{
   
    protected static ?string $title = ' tambah pemeriksa ibu hamil';
    protected static string $resource = PeriksaibuhamilResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    
}
