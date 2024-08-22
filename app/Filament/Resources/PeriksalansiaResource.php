<?php

namespace App\Filament\Resources;

use actions;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use App\Models\Periksalansia;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\PeriksalansiaExporter;
use App\Filament\Imports\PeriksalansiaImporter;
use Filament\Infolists\Components\Actions\Action;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PeriksalansiaResource\Pages;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Resources\PeriksalansiaResource\RelationManagers;
use App\Filament\Resources\PeriksalansiaResource\Pages\EditPeriksalansia;
use App\Filament\Resources\PeriksalansiaResource\Pages\ListPeriksalansias;
use App\Filament\Resources\PeriksalansiaResource\Pages\CreatePeriksalansia;

class PeriksalansiaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Periksalansia::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'pemeriksaan';
    protected static ?string $modelLabel = 'pemeriksaan lansia';
    protected static ?string $navigationLabel = 'lansia';
    public static function getPluralLabel(): string
    {
        return __('pemeriksaan lansia');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('lansia_id')
                            ->relationship('lansia', 'nama',)
                            ->label('Nama Lansia')
                            ->searchable(['nama', 'nik'])
                            ->required()
                            ->columnSpan('2')
                            ->placeholder('masukkan nama/nik')
                            ->reactive(),
                    ])->columns(2),
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
                        TextInput::make('LP')
                            ->label('Lingkar perut')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('tanda vital')
                    ->schema([
                        // TextInput::make('TD')
                        //     ->label('Tekanan darah (sis/dias)')
                        //     ->placeholder('sistolik/diastolik')
                        //     ->required()
                        //     ->columnSpan('1'),
                        TextInput::make('TDSI')
                            ->label('Tekanan darah sistolik')
                            ->placeholder('mmHg')
                            ->required(),
                        // ->columnSpan('1'),
                        TextInput::make('TDDI')
                            ->label('Tekanan darah diastolik')
                            ->placeholder('mmHg')
                            ->required(),
                        TextInput::make('nadi')
                            ->label('NADI')
                            ->placeholder('bpm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                    ])->columns(2),
                Forms\Components\Section::make('Pemeriksaan LAB')
                    ->schema([
                        TextInput::make('GD')
                            ->label('Gula darah')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        TextInput::make('AS')
                            ->label('Asam urat')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        TextInput::make('CHOL')
                            ->label('colestrol')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                    ])->columns('3'),
                Forms\Components\Section::make('Mental emosional')
                    ->schema([
                        TextInput::make('GEP')
                            ->label('Gangguan emosi/prilaku')
                            ->placeholder('keterangan')
                        // ->placeholder('TT')
                        ,
                        TextInput::make('SGDS')
                            ->label('Sekor GDS')
                            ->numeric()
                            ->placeholder('0-30'),
                        TextInput::make('koghnitif')
                            // ->label('s')
                            ->numeric()
                            ->placeholder('0-30'),
                        TextInput::make('AMT')
                            ->label('Tes Mental Singkat')
                            ->numeric()
                            ->placeholder('0-10'),
                    ])->columns('2'),
                Forms\Components\Section::make('Mental emosional')
                    ->schema([
                        TextInput::make('RJ')
                            ->label('Risiko jatuh')
                            ->numeric()
                            ->placeholder('%'),
                        TextInput::make('ADL')
                            ->label('Aktifitas sehari-hari')
                            ->placeholder('kegaitan'),
                        Forms\Components\Select::make('kemandirian')
                            ->options([
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                            ])
                    ])->columns('3'),
                Forms\Components\Section::make('Gangguan Fisik')
                    ->schema([
                        TextInput::make('kencing')
                            ->label('Kencing')
                            ->placeholder('keterangan'),
                        TextInput::make('mata')
                            ->label('Pengelihatan')
                            ->placeholder('keterangan'),
                        TextInput::make('telinga')
                            ->label('pendengaran')
                            ->placeholder('keterangan'),
                    ])->columns('3'),
            ])->columns('2');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan hasil pemeriksaan')
            ->columns([
                TextColumn::make('lansia.nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('BB')
                    ->label('Berat badan')
                    ->searchable()
                    ->sortable()
                    ->suffix('  Kg')
                    ->summarize(
                        Summarizer::make()
                            ->label('Berat normal')
                            ->placeholder('25-27 Kg')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 27  => 'warning',
                        // $state ==  => 'success',
                        $state < 25 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->BB > 27 => 'Kelebihan berat badan',
                        // $record->berat == 85 => 'Berat normal',
                        $record->BB < 25 => 'Kekurangan Berat badan',
                        default => 'Berat normal',
                    }),
                TextColumn::make('TB')
                    ->label('Tinggi badan')
                    ->searchable()
                    ->suffix('  Cm')
                    ->sortable(),
                TextColumn::make('LP')
                    ->label('Lingkar perut')
                    ->searchable()
                    ->sortable()
                    ->suffix('  Cm')
                    ->summarize(
                        Summarizer::make()
                            ->label('lingkar normal')
                            ->placeholder('<102 cm pria, <88 cm wanita')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 120  => 'warning',
                        // $state ==  => 'success',
                        $state < 88 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->LP > 120 => 'lingkar perut di atas normal',
                        // $record->berat == 85 => 'Berat normal',
                        $record->LP < 88 => 'Lingkar perut di bawah normal',
                        default => 'Lingkar normal',
                    }),
                TextColumn::make('TDSI')
                    ->label('Tekanan darah sistolik')
                    ->searchable()
                    ->sortable()
                    ->suffix('  mmHg')
                    ->summarize(
                        Summarizer::make()
                            ->label('Tekanan normal')
                            ->placeholder('120 mmHg')

                    )->color(fn(int $state): string => match (true) {
                        $state > 120  => 'warning',
                        // $state ==  => 'success',
                        $state < 120 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->TDSI > 120 => 'Tekanan darah tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->TDSI < 120 => 'Tekanan darah rendah',
                        default => 'Tekanan normal',
                    }),
                TextColumn::make('TDDI')
                    ->label('Tekanan darah diastolik')
                    ->searchable()
                    ->sortable()
                    ->suffix('  mmHg')
                    ->summarize(
                        Summarizer::make()
                            ->label('Tekanan normal')
                            ->placeholder('80 mmHg')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 80  => 'warning',
                        // $state ==  => 'success',
                        $state < 80 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->TDDI > 80 => 'Tekanan darah tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->TDDI < 80 => 'Tekanan darah rendah',
                        default => 'Tekanan normal',
                    }),
                TextColumn::make('GD')
                    ->label('gula darah')
                    ->searchable()
                    ->sortable()
                    ->suffix('  mg/dl')
                    ->summarize(
                        Summarizer::make()
                            ->label('Gula darah normal')
                            ->placeholder('180 mg/dl')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 180  => 'warning',
                        // $state ==  => 'success',
                        $state < 180 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->GD > 180 => 'Gula darah tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->GD < 180 => 'Gula darah rendah',
                        default => 'Gula darah normal',
                    }),
                TextColumn::make('AS')
                    ->label('Asam urat')
                    ->searchable()
                    ->sortable()
                    ->suffix('  mg/dl')
                    ->summarize(
                        Summarizer::make()
                            ->label('Asam urat normal')
                            ->placeholder('3,5-7,2 mg/dL')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 7  => 'warning',
                        // $state ==  => 'success',
                        $state < 4 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->CHOL > 7 => 'Asam urat tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->CHOL < 4 => 'Asam urat rendah',
                        default => 'normal',
                    }),
                TextColumn::make('CHOL')
                    ->label('kolestrol')
                    ->searchable()
                    ->sortable()
                    ->suffix('  mg/dl')
                    ->summarize(
                        Summarizer::make()
                            ->label('kolestrol normal')
                            ->placeholder('<200 mg/dL')

                    )
                    ->color(fn(int $state): string => match (true) {
                        $state > 200  => 'warning',
                        // $state ==  => 'success',
                        $state < 200 => 'danger',
                        default => 'success',
                    })
                    ->description(fn($record): string => match (true) {
                        $record->CHOL > 200 => 'Kolestrol tinggi',
                        // $record->berat == 85 => 'Berat normal',
                        $record->CHOL < 200 => 'Kolestrol rendah',
                        default => 'Kolestrol normal',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->label('detail'),
                Tables\Actions\EditAction::make()->label('ubah'),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(PeriksalansiaImporter::class)
                    ->label('import')
                    ->color('success')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('import_periksalansia')),
                ExportAction::make()
                    ->exporter(PeriksalansiaExporter::class)
                    ->label('Export semua')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_periksalansia')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus'),
                ]),
                ExportBulkAction::make()
                    ->exporter(PeriksalansiaExporter::class)
                    ->label('Export item')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_periksalansia')),
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
                        TextEntry::make('lansia.nama')
                            ->label('nama')
                            ->color('warning'),
                        TextEntry::make('lansia.nik')->label('NIK')->color('warning'),
                        TextEntry::make('BB')->label('Berat badan')->color('warning'),
                        TextEntry::make('TB')->label('Tinggi badan')->color('warning'),
                        TextEntry::make('LP')->label('Lingkar perut')->color('warning'),
                        TextEntry::make('TDSI')->label('tekanan darah sistolik')->color('warning'),
                        TextEntry::make('TDDI')->label('tekanan darah distolik')->color('warning'),
                        TextEntry::make('nadi')->label('nadi')->color('warning'),
                        TextEntry::make('GD')->label('Gula darah')->color('warning'),
                        TextEntry::make('AS')->label('Asam urat')->default('-')->color('warning'),
                        TextEntry::make('CHOL')->label('Colestrol')->default('-')->color('warning'),
                        TextEntry::make('GEP')->label('Gangguan emosi')->default('-')->color('warning'),
                        TextEntry::make('SGDS')->label('Sekor GDS')->default('-')->color('warning'),
                        TextEntry::make('koghnitif')->label('koghnitif')->default('-')->color('warning'),
                        TextEntry::make('RJ')->label('Risiko jatuh')->default('-')->color('warning'),
                        TextEntry::make('ADL')->label('Aktifitas sehari-hari')->default('-')->color('warning'),
                        TextEntry::make('kemandirian')->label('Kemandirian')->default('-')->color('warning'),
                        TextEntry::make('kencing')->label('Kencing')->default('-')->color('warning'),
                        TextEntry::make('mata')->label('pengelihatan')->default('-')->color('warning'),
                        TextEntry::make('telinga')->label('Pendengaran')->default('-')->color('warning'),
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
            'index' => ListPeriksalansias::route('/'),
            'create' => CreatePeriksalansia::route('/create'),
            'edit' => EditPeriksalansia::route('/{record}/edit'),
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
