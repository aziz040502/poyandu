<?php

namespace App\Filament\Imports;

use App\Models\Periksalansia;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PeriksalansiaImporter extends Importer
{
    protected static ?string $model = Periksalansia::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('lansia')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama')
                ->rules(['required'])
                ->examples(['siti zulaiha']),
            // ImportColumn::make('lansia_nik')
            //     ->rules(['max:255']),
            ImportColumn::make('BB')
                ->label('berat badan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['70.1']),
            ImportColumn::make('TB')
                ->label('tinggi badan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['150']),
            ImportColumn::make('LP')
                ->label('lingkar perut')
                ->rules(['max:255'])
                ->examples(['78']),
            ImportColumn::make('TDSI')
                ->label('tekanan darah sistolik')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['120']),
            ImportColumn::make('TDDI')
                ->label('tekanan darah diastolik')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['80']),
            ImportColumn::make('nadi')
                ->label('nadi')
                ->rules(['max:255']),
            ImportColumn::make('GD')
                ->label('gula darah')
                ->rules(['max:255'])
                ->examples(['80']),
            ImportColumn::make('AS')
                ->label('asam urat')
                ->rules(['max:255']),
            ImportColumn::make('CHOL')
                ->label('kolesterol')
                ->rules(['max:255'])
                ->examples(['180']),
            ImportColumn::make('GEP')
                ->label('Gangguan emosi')
                ->rules(['max:255']),
            ImportColumn::make('SGDS')
                ->label('sekor SDGS')
                ->rules(['max:255']),
            ImportColumn::make('koghnitif')
                ->label('kognitif')
                ->rules(['max:255']),
            ImportColumn::make('AMT')
                ->label('aktivitas motorik')
                ->rules(['max:255']),
            ImportColumn::make('RJ')
                ->label('Risiko jatuh')
                ->rules(['max:255']),
            ImportColumn::make('ADL')
                ->label('aktivitas sehari hari')
                ->rules(['max:255']),
            ImportColumn::make('kemandirian')
                ->rules(['max:255']),
            ImportColumn::make('kencing')
                ->label('kencing')
                ->rules(['max:255']),
            ImportColumn::make('mata')
                ->label('pengelihatan')
                ->rules(['max:255']),
            ImportColumn::make('telinga')
                ->label('pendengaran')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Periksalansia
    {
        // return Periksalansia::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Periksalansia();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your periksalansia import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
