<?php

namespace App\Filament\Exports;

use App\Models\Periksalansia;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PeriksalansiaExporter extends Exporter
{
    protected static ?string $model = Periksalansia::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id')
            //     ->label('ID'),
            ExportColumn::make('lansia.nama')->label('nama'),
            ExportColumn::make('lansia.nik')->label('nik'),
            ExportColumn::make('BB')->label('berat badan'),
            ExportColumn::make('TB')->label('tinggi badan'),
            ExportColumn::make('LP')->label('lingkar perut'),
            ExportColumn::make('TDSI')->label('tinggi dada sebelah ibu'),
            ExportColumn::make('TDDI')->label('tinggi dada sebelah ida'),
            ExportColumn::make('nadi')->label('nadi'),
            ExportColumn::make('GD')->label('gula darah'),
            ExportColumn::make('AS')->label('asam urat'),
            ExportColumn::make('CHOL')->label('serum cholesterol'),
            ExportColumn::make('GEP')->label('gula enterokokal'),
            ExportColumn::make('SGDS')->label('sekor sgds'),
            ExportColumn::make('koghnitif')->label('koghnitif'),
            ExportColumn::make('AMT')->label('tes mental singkat'),
            ExportColumn::make('RJ')->label('resiko jatuh'),
            ExportColumn::make('ADL')->label('aktifitas sehari-hari'),
            ExportColumn::make('kemandirian')->label('kemandirian'),
            ExportColumn::make('kencing'),
            ExportColumn::make('mata')->label('pengelihatan'),
            ExportColumn::make('telinga')->label('pendengaran'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your periksalansia export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
