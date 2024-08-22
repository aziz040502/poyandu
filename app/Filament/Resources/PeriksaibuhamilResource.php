<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Periksaibuhamil;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\Summarizers\Range;
use App\Filament\Exports\PeriksabalitaExporter;
use Filament\Tables\Columns\Summarizers\Average;
use App\Filament\Exports\PeriksaibuhamilExporter;
use App\Filament\Imports\PeriksaibuhamilImporter;
use Filament\Tables\Columns\Summarizers\Summarizer;
use App\Filament\Resources\PeriksaibuhamilResource\Pages;
use Filament\Infolists\Components\IconEntry\IconEntrySize;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Resources\PeriksaibuhamilResource\RelationManagers;
use App\Filament\Resources\PeriksaibuhamilResource\Pages\EditPeriksaibuhamil;
use App\Filament\Resources\PeriksaibuhamilResource\Pages\ListPeriksaibuhamils;
use App\Filament\Resources\PeriksaibuhamilResource\Pages\CreatePeriksaibuhamil;


class PeriksaibuhamilResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Periksaibuhamil::class;
    protected static ?string $navigationLabel = 'ibu hamil';
    protected static ?string $modelLabel = 'pemeriksaan  ibu hamil';
    protected static ?string $navigationGroup = 'pemeriksaan';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public static function getPluralLabel(): string
    {
        return __('pemeriksaan ibu hamil');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Select::make('ibuhamil_id')
                            ->relationship('ibuhamil', 'nama',)
                            ->searchable(['nama', 'nik'])
                            ->required()
                            ->columnSpan('2')
                            ->placeholder('masukkan nama/nik')
                            ->reactive()
                            ->afterStateUpdated(
                                function (Get $get, Set $set) {
                                    $ibuHamil = \App\Models\ibuhamil::find($get('ibuhamil_id'));
                                    if ($ibuHamil) {
                                        $set('HPHT', $ibuHamil->HPHTB);

                                        // Calculate and set UK and PTP based on HPHT
                                        $hpht = Carbon::parse($get('HPHT'));
                                        $now = Carbon::now();

                                        if ($hpht->isFuture()) {
                                            $set('UK', 'HPHT tidak boleh di masa depan');
                                            $set('PTP', null);
                                            return;
                                        }

                                        $ageInDays = $now->diffInDays($hpht);
                                        $ukWeeks = floor(abs($ageInDays / 7));
                                        $ukDays = abs($ageInDays % 7);

                                        if ($ukWeeks > 45) {
                                            $set('UK', 'Usia kehamilan melebihi 45 minggu');
                                            $set('PTP', null);
                                        } else {
                                            $set('UK', "$ukWeeks minggu $ukDays hari");

                                            // Calculate and set estimated delivery date
                                            $estimatedDeliveryDate = $hpht->copy()->addDays(280);
                                            $set('PTP', $estimatedDeliveryDate->format('Y-m-d'));
                                        }
                                    }
                                }
                            ),
                        DatePicker::make('HPHT')
                            ->label('Hari Pertama Haid Terakhir')
                            ->native(false)
                            ->required()
                            ->disabled()
                            ->reactive()
                            ->dehydrated(true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                if ($get('HPHT')) {
                                    $hpht = Carbon::parse($get('HPHT'));
                                    $now = Carbon::now();

                                    if ($hpht->isFuture()) {
                                        $set('UK', 'HPHT tidak boleh di masa depan');
                                        $set('PTP', null);
                                        return;
                                    }

                                    $ageInDays = $now->diffInDays($hpht);
                                    $ukWeeks = floor(abs($ageInDays / 7));
                                    $ukDays = abs($ageInDays % 7);

                                    if ($ukWeeks > 45) {
                                        $set('UK', 'Usia kehamilan melebihi 45 minggu');
                                        $set('PTP', null);
                                    } else {
                                        $set('UK', "$ukWeeks minggu $ukDays hari");

                                        // Calculate and set estimated delivery date
                                        $estimatedDeliveryDate = $hpht->copy()->addDays(280);
                                        $set('PTP', $estimatedDeliveryDate->format('Y-m-d'));
                                    }
                                }
                            }),
                        TextInput::make('UK')
                            ->label('Usia Kehamilan ')
                            ->placeholder('minggu/hari')
                            ->required()
                            ->disabled()
                            ->columnSpan('2')
                            ->dehydrated(true),
                        DatePicker::make('PTP')
                            ->label('Perkiraan Tanggal Persalinan')
                            ->disabled()
                            ->required()
                            ->native(false)
                            ->dehydrated(true)
                            ->rules(['date']),
                    ])->columns(3),
                Forms\Components\Section::make('Status gizi')
                    ->schema([
                        TextInput::make('BB')
                            ->label('Berat badan ')
                            ->placeholder('kg')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        TextInput::make('TB')
                            ->label('Tinggi badan ')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        TextInput::make('lila')
                            ->label('Lingkar Lengan ')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Pemeriksaan Fisik')
                    ->schema([
                        //   Section::make('tekanan darah')
                        // ->schema([
                        TextInput::make('TDSI')
                            ->label('Tekanan darah sistolik')
                            ->placeholder('sistolik')
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        // ->columnSpan('1'),
                        TextInput::make('TDDI')
                            ->label('Tekanan darah diastolik')
                            ->placeholder('diastolik')
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        // ])->columns(2),
                        TextInput::make('TFU')
                            ->label('Tinggi Fundus Uteri')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        TextInput::make('DJJ')
                            ->label('Denyut jantung bayi ')
                            ->placeholder('dpm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        TextInput::make('LJ')
                            ->label('Letak Janin')
                            ->placeholder('I/E'),
                    ])->columns(2),
                Forms\Components\Section::make('Tes Laboratorium')
                    ->schema([
                        TextInput::make('HB')
                            ->label('hemoglobin')
                            ->placeholder('g/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        TextInput::make('GDS')
                            ->label('Glukosa Darah Sewaktu')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        TextInput::make('PU')
                            ->label('Protein urin')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                    ])->columns('3'),
                Forms\Components\Section::make('Pelayanan/Pemberian')
                    ->schema([
                        TextInput::make('TT')
                            ->label('vaksin tetanus')
                            // ->placeholder('')
                            ->placeholder('TT'),
                        TextInput::make('TTD')
                            ->label('Tablet tambah darah')
                            ->placeholder('Dosis obat'),
                        TextInput::make('PMTpemulihan')
                            ->label('PMT pemulihan')
                            ->placeholder('PMT yang diberikan'),
                        TextInput::make('rujukan')
                            ->label('rujukan')
                            ->placeholder('keterangan'),
                        Toggle::make('bukuKIA')
                            ->label('memiliki buku KIA')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                    ])->columns('3'),
            ])->columns('2');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan hasil pemeriksaan')
            ->columns([
                TextColumn::make('ibuhamil.nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('UK')
                    ->label('usia kehamilan')
                    ->searchable()
                    ->sortable()
                    ->summarize(
                        Summarizer::make()
                            ->label('Minggu/hari')
                        // ->placeholder(' (IMT) normal 18,5-24,9 Kg')

                    ),
                TextColumn::make('PTP')
                    ->label('Perediksi Bersalin')
                    ->date(),
                TextColumn::make('BB')
                    ->label('Berat badan')
                    ->searchable()
                    ->sortable()
                    ->suffix('  Kg')
                    ->summarize(
                        Summarizer::make()
                            ->label('Berat normal')
                            ->placeholder('(IMT) normal 45-65 Kg')
                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 65  => 'warning',
                        // $state ==  => 'success',
                        $state < 45 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->BB > 65 => 'kelebihan berat badan',
                        // $record->berat == 85 => 'Berat normal',
                        $record->BB < 45 => 'Kekurang berat badan',
                        default => 'normal',
                    }),
                TextColumn::make('TB')
                    ->label('Tinggi badan')
                    ->searchable()
                    ->suffix('  Cm')
                    ->sortable(),
                TextColumn::make('lila')
                    ->label('Lingkar lengan')
                    ->searchable()
                    ->suffix('  Cm')
                    ->sortable(),
                TExtColumn::make('TDSI')
                    ->label('tekanan darah sistolik')
                    ->searchable()
                    ->sortable()
                    ->suffix('  Hg')
                    ->summarize(
                        Summarizer::make()
                            ->label('Tekanan normal')
                            ->placeholder('110-120 Hg')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 120  => 'warning',
                        // $state ==  => 'success',
                        $state < 110 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->TDSI > 120 => 'Tekanan darah tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->TDSI < 110 => 'Tekanan darah rendah',
                        default => 'Tekanan normal',
                    }),
                TExtColumn::make('TDDI')
                    ->label('tekanan darah diastolik')
                    ->searchable()
                    ->sortable()
                    ->suffix('  Hg')
                    ->summarize(
                        Summarizer::make()
                            ->label('Tekanan normal')
                            ->placeholder('70-80 Hg')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 80  => 'warning',
                        // $state ==  => 'success',
                        $state < 70 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->TDDI > 80 => 'Tekanan darah tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->TDDI < 70 => 'Tekanan darah rendah',
                        default => 'Tekanan normal',
                    }),
                TExtColumn::make('HB')
                    ->label('hemoglobin')
                    ->searchable()
                    ->sortable()
                    ->suffix('  g/dl')
                    ->summarize(
                        Summarizer::make()
                            ->label('Tekanan normal')
                            ->placeholder('70-80 g/dl')

                    )->color(fn(int $state): string => match (true) {
                        $state > 80  => 'warning',
                        // $state ==  => 'success',
                        $state < 70 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->HB > 80 => 'kelebihan Hemoglobin',
                        // $record->berat == 85 => 'Berat normal',
                        $record->HB < 70 => 'Kekurangan hemoglobin',
                        default => 'Hemoglobin normal',
                    }),
                TExtColumn::make('DJJ')
                    ->label('Denyut jantung bayi')
                    ->searchable()
                    ->sortable()
                    ->suffix('  DPM')
                    ->summarize(
                        Summarizer::make()
                            ->label('Denyut normal')
                            ->placeholder('100-160 DPM')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 160  => 'warning',
                        // $state ==  => 'success',
                        $state < 100 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->DJJ > 160 => 'Denyut jantung tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->DJJ < 100 => 'Denyut jantung lemah',
                        default => 'Denyut normal',
                    }),
                TExtColumn::make('GDS')
                    ->label('Glukosa darah')
                    ->searchable()
                    ->sortable()
                    ->suffix('  Mg/dl')
                    ->summarize(
                        Summarizer::make()
                            ->label('glukosa normal')
                            ->placeholder('90-120 Mg/dl')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 120  => 'warning',
                        // $state ==  => 'success',
                        $state < 90 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->GDS > 120 => 'Glukosa tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->GDS < 90 => 'Glukosa rendah',
                        default => 'Glukosa normal',
                    }),

            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->label('detail'),
                EditAction::make()->label('ubah'),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(PeriksaibuhamilImporter::class)
                    ->label('import')
                    ->color('success')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('import_periksaibuhamil')),
                ExportAction::make()
                    ->exporter(PeriksaibuhamilExporter::class)
                    ->label('Export semua')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_periksaibuhamil')),

            ])
            ->bulkActions([

                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('hapus'),
                ]),
                ExportBulkAction::make()
                    ->exporter(PeriksaibuhamilExporter::class)
                    ->label('Export item')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_periksaibuhamil')),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Tanggal ditambah')
                            // ->columnSpan('full')
                            ->date()
                            ->color('warning'),
                        TextEntry::make('updated_at')
                            ->label('Tanggal diubah')
                            ->date()
                            ->color('warning'),
                    ])->columns('3'),
                Section::make()
                    ->schema([
                        // TextEntry::make('ibu_hamil.nama')
                        // ->label('nama')
                        // ->color('warning'),
                        // TextEntry::make('ibu_hamil.nik')->label('NIK')->color('warning'),
                        TextEntry::make('BB')->label('Berat badan')->color('warning'),
                        TextEntry::make('TB')->label('Tinggi badan')->color('warning'),
                        TextEntry::make('lila')->label('Lingkar lengan')->color('warning'),
                        TextEntry::make('UK')->label('Usia kehamilan')->color('warning'),
                        TextEntry::make('BB')->label('Berat badan')->color('warning'),
                        TextEntry::make('TB')->label('Tinggi badan')->color('warning'),
                        TextEntry::make('TDSI')->label('Tekanan darah sistolik')->default('-')->color('warning'),
                        TextEntry::make('TDDI')->label('Tekanan darah diastolik')->default('-')->color('warning'),
                        TextEntry::make('TFU')->label('Tinggi Fundus Uteri')->default('-')->color('warning'),
                        TextEntry::make('DJJ')->label('Denyut jantung bayi')->default('-')->color('warning'),
                        TextEntry::make('LJ')->label('Letak Janin')->default('-')->color('warning'),
                        TextEntry::make('HB')->label('hemoglobin')->default('-')->color('warning'),
                        TextEntry::make('GDS')->label('Glukosa Darah Sewaktu')->default('-')->color('warning'),
                        TextEntry::make('PU')->label('Protein urine')->default('-')->color('warning'),
                        TextEntry::make('TT')->label('Vaksin tetanus')->default('-')->color('warning'),
                        TextEntry::make('TTD')->label('Tablet tambah darah')->default('-')->color('warning'),
                        TextEntry::make('PMTpemulihan')->label('PMT pemulihan')->default('-')->color('warning'),
                        TextEntry::make('rujukan')->default('-')->color('warning'),
                        IconEntry::make('bukuKIA')
                            ->label('membawa buku KIA')
                            ->size(IconEntrySize::Medium),
                    ])->columns('3'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPeriksaibuhamils::route('/'),
            'create' => CreatePeriksaibuhamil::route('/create'),
            'edit' => EditPeriksaibuhamil::route('/{record}/edit'),
        ];
    }
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'import',
            'export',
        ];
    }
}
