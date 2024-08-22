<?php

namespace App\Filament\Imports;

use App\Models\IbuHamil;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class IbuHamilImporter extends Importer
{
    protected static ?string $model = IbuHamil::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['dara', 'dewi persik']),
            ImportColumn::make('suami')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['muhammad aziz', 'reza']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['6859648948432569', '6859648948432564']),
            ImportColumn::make('TTL')
                ->label('Tempat Tanggal Lahir')
                ->requiredMapping()
                ->rules(['required', 'date'])
                ->examples(['1997/12/24', '2000/7/12']),
            ImportColumn::make('dusun')
                ->requiredMapping()
                // ->relationship()
                ->relationship(resolveUsing: 'name')
                ->rules(['required'])
                ->examples(['baret orong', 'jorong daya']),
            ImportColumn::make('PHBT')
                ->label('Hari Pertama Haid Terakhir')
                ->requiredMapping()
                ->rules(['required', 'date'])
                ->examples(['2024/12/24', '2024/7/12']),
        ];
    }

    public function resolveRecord(): ?IbuHamil
    {
        // return IbuHamil::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new IbuHamil();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your ibu hamil import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
