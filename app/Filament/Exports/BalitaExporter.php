<?php

namespace App\Filament\Exports;

use App\Models\Balita;
use Filament\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;


class BalitaExporter extends Exporter
{
    protected static ?string $model = Balita::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id'),
            ExportColumn::make('nama'),
            ExportColumn::make('nik'),
            ExportColumn::make('TTL'),
            ExportColumn::make('gender'),
            ExportColumn::make('ayah'),
            ExportColumn::make('ibu'),
            ExportColumn::make('dusun.name'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your balita export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
    // public function toBroadcast(Balita $notifiable): BroadcastMessage
    // {
    //     return Notification::make()
    //         ->title('Saved successfully')
    //         ->getBroadcastMessage();
    // }
}
