<?php

namespace App\Filament\Resources\BalitaResource\Pages;

use App\Filament\Resources\BalitaResource;
use App\Models\balita;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBalita extends EditRecord
{
    protected static string $resource = BalitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User updated')
            ->body('The user has been saved successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
