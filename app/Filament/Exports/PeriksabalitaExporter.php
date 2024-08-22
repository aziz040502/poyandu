<?php

namespace App\Filament\Exports;

use App\Models\Periksabalita;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use PhpParser\Node\Stmt\Label;

class PeriksabalitaExporter extends Exporter
{
    protected static ?string $model = Periksabalita::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id')
            //     ->label('ID'),
            ExportColumn::make('balita.id')->label('balita'),
            ExportColumn::make('balita_nik')->label('nik'),
            ExportColumn::make('BB')->label('berat badan'),
            ExportColumn::make('TB')    ->label('tinggi badan'),
            ExportColumn::make('lila')->label('lingkar lengan'),
            ExportColumn::make('menyusuidini')->label('menyusui dini'),
            ExportColumn::make('lika')->label('lingkar kepala'),
            ExportColumn::make('rujukan')->label('rujukan'),
            ExportColumn::make('imunisasi')->label('imunisasi'),    
            ExportColumn::make('PMTpemulihan')->label('PMT pemulihan'),
            ExportColumn::make('vitamin'),
            ExportColumn::make('obatcacing'),
            ExportColumn::make('is_visible')->label('buku KIA'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your periksabalita export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
