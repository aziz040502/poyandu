<?php

namespace App\Filament\Imports;

use App\Models\Periksaibuhamil;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PeriksaibuhamilImporter extends Importer
{
    protected static ?string $model = Periksaibuhamil::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('ibu_hamil')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama')
                ->rules(['required'])
                ->examples(['marni']),
            // ImportColumn::make('ibu_hamil_nik')
            //     ->rules(['max:255']),
            // ImportColumn::make('UK')
            //     ->label('usia kehamilan')
            //     ->requiredMapping()
            //     ->rules(['required', 'max:255'])
            //     ->examples(['4/5']),
            ImportColumn::make('BB')
                ->label('brat badan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['57']),
            ImportColumn::make('TB')
                ->label('tinggi badan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['160']),
            ImportColumn::make('lila')
                ->label('lingkar lengan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['17.5']),
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
            ImportColumn::make('TFU')
                ->label('tinggi fundus uteri')
                ->rules(['max:255'])
                ->examples(['2']),
            ImportColumn::make('DJJ')
                ->label('denyut jantung bayi')
                ->rules(['max:255']),
            ImportColumn::make('LJ')
                ->label('letak janin')
                ->rules(['max:255']),
            ImportColumn::make('HB')
                ->label('hemoglobin')
                ->rules(['max:255']),
            ImportColumn::make('GDS')
                ->label('glukosa darah sewaktu')
                ->rules(['max:255'])
                ->examples(['100']),
            ImportColumn::make('PU')
                ->label('protein urin')
                ->rules(['max:255']),
            ImportColumn::make('TT')
                ->label('vaksin tetanus')
                ->rules(['max:255']),
            ImportColumn::make('TTD')
                ->label('tablet tambah darah')
                ->rules(['max:255']),
            ImportColumn::make('PMTpemulihan')
                ->label('PMT pemulihan')
                ->rules(['max:255']),
            ImportColumn::make('rujukan')
                ->label('rujukan')
                ->rules(['max:255']),
            ImportColumn::make('bukuKIA')
                ->label('buku KIA')
                ->requiredMapping()
                ->boolean()
                ->rules(['boolean'])
                ->examples(['yes']),
        ];
    }

    public function resolveRecord(): ?Periksaibuhamil
    {
        // return Periksaibuhamil::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Periksaibuhamil();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your periksaibuhamil import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
