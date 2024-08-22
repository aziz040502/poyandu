<?php

namespace App\Filament\Resources\BalitaResource\Pages;

use App\Filament\Resources\BalitaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ViewBalitas extends ViewRecord
{
    protected static string $resource = balitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
