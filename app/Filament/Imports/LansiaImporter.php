<?php

namespace App\Filament\Imports;

use App\Models\Lansia;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class LansiaImporter extends Importer
{
    protected static ?string $model = Lansia::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['sanah', 'tanah']),
            ImportColumn::make('nik')
                ->label('nomer induk kependudukan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['6564533434342323', '6564533434842323']),
            ImportColumn::make('TTL')
                ->requiredMapping()
                ->rules(['required', 'date'])
                ->examples(['1970/12/13', '1972/9/18']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required'])
                ->examples(['laki-laki', 'perempuan']),
            ImportColumn::make('dusun')
                ->requiredMapping()
                // ->relationship()
                ->relationship(resolveUsing: 'name')
                ->rules(['required'])
                ->examples(['jorong daya', 'baret orong']),
        ];
    }

    public function resolveRecord(): ?Lansia
    {
        // return Lansia::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Lansia();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your lansia import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
