<?php

namespace App\Filament\Imports;

use App\Models\Balita;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BalitaImporter extends Importer
{
    protected static ?string $model = Balita::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['muhammad aziz', 'dewi persik']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['4594858695695689', '4569569569569569']),
            ImportColumn::make('TTL')
                ->label('Tempat Tanggal Lahir')
                ->requiredMapping()
                // ->native(false)
                // ->displayFormat('d/m/Y')
                ->rules(['required', 'date'])
                ->examples(['2024/12/29', '2024/12/29']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required'])
                ->examples(['laki-laki', 'perempuan']),
            ImportColumn::make('ayah')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['sahdan', 'marwan']),
            ImportColumn::make('ibu')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['marsinah', 'rena']),
            ImportColumn::make('dusun')
                ->requiredMapping()
                // ->relationship()
                ->relationship(resolveUsing: 'name')
                ->rules(['required'])
                ->examples(['beak daya', 'baret orong']),
        ];
    }

    public function resolveRecord(): ?Balita
    {
        // return Balita::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        if ($this->options['updateExisting'] ?? false) {
            return Balita::firstOrNew([
                'nama' => $this->data['nama'],
            ]);
        }

        return new Balita();
    }
    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'data balita berhasil diExport ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
