<?php

namespace App\Filament\Imports;

use App\Models\Periksabalita;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class PeriksabalitaImporter extends Importer implements  FilamentUser
{
    use HasRoles;
    use HasPanelShield;
    protected static ?string $model = Periksabalita::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('balita')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama')
                ->rules(['required'])
                ->examples(['sandi', 'marni']),
            // ImportColumn::make('balita_nik')
            //     ->label('nomer induk kependudukan')
            //     ->rules(['max:255'])
            //     ->examples(['6756956845453436', '6756954846453436']),
            ImportColumn::make('BB')
                ->label('berat badan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['12', '10']),
            ImportColumn::make('TB')
                ->label('tinggi badan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['74', '70']),
            ImportColumn::make('lila')
                ->label('lingkar lengan')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['13', '15']),
            ImportColumn::make('menyusuidini')
                ->label('menyusui dini')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->examples(['yes', 'no']),
            ImportColumn::make('lika')
                ->label('lingkar kepala')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['45', '48']),
            ImportColumn::make('rujukan'),
            ImportColumn::make('imunisasi')
                ->rules(['max:255']),
            ImportColumn::make('PMTpemulihan')
                ->label('PMT Pemulihan')
                ->rules(['max:255']),
            ImportColumn::make('vitamin'),
            ImportColumn::make('obatcacing')
                ->rules(['max:255']),
            // ImportColumn::make('is_visible')
            //     ->label('buku KIA')
            //     // ->requiredMapping()
            //     ->boolean()
            //     ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): ?Periksabalita
    {
        // return Periksabalita::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Periksabalita();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your periksabalita import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
