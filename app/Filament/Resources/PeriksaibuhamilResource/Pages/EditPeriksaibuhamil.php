<?php

namespace App\Filament\Resources\PeriksaibuhamilResource\Pages;

use App\Filament\Resources\PeriksaibuhamilResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriksaibuhamil extends EditRecord
{
    protected static ?string $title = ' ubah pemeriksa ibu hamil';
    protected static string $resource = PeriksaibuhamilResource::class;

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
