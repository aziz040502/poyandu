<?php

namespace App\Filament\Exports;

use App\Models\Periksaibuhamil;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PeriksaibuhamilExporter extends Exporter
{
    protected static ?string $model = Periksaibuhamil::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id')
            //     ->label('ID'),
            ExportColumn::make('ibu_hamil.nama')->label('nama'),
            ExportColumn::make('ibu_hamil.nik')->label('nik'),
            ExportColumn::make('UK')->label('umur'),
            ExportColumn::make('BB')->label('berat badan'),
            ExportColumn::make('TB')->label('tinggi badan'),
            ExportColumn::make('lila')->label('lingkar lengan'),
            ExportColumn::make('TDSI')->label('tinggi dada sebelah ibu'),   
            ExportColumn::make('TDDI')->label('tinggi dada sebelah ibu'),
            ExportColumn::make('TFU') ->label('tinggi fundus ukuran uteri'),
            ExportColumn::make('DJJ')->label('tinggi jari jari jantung'),
            ExportColumn::make('LJ')->label('lingkar jari jari jantung'),
            ExportColumn::make('HB')->label('tinggi badan'),
            ExportColumn::make('GDS')->label('gigi dada sebelah ibu'),  
            ExportColumn::make('PU')->label('perkembangan usia'),
            ExportColumn::make('TT')->label('tanda tangan'),
            ExportColumn::make('TTD')->label('tanggal ttd'),
            ExportColumn::make('PMTpemulihan')->label('pemberian makanan terakhir'),
            ExportColumn::make('rujukan')->label('rujukan'),
            ExportColumn::make('bukuKIA')->label('buku KIA'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your periksaibuhamil export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
