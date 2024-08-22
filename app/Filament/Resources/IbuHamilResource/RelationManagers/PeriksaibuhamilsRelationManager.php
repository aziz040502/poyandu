<?php

namespace App\Filament\Resources\IbuHamilResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;


class PeriksaibuhamilsRelationManager extends RelationManager
{
    protected static string $relationship = 'periksaibuhamils';
    protected static ?string $title = 'Pemeriksaan Ibu Hamil';
    protected static ?string $modelLabel = 'Hasil Pemeriksaan';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        // Forms\Components\Select::make('ibu_hamil_id')
                        //     ->relationship('ibu_hamil', 'nama',)
                        //     ->searchable()
                        //     ->required()
                        //     ->columnSpan('2')
                        //     ->reactive(),
                        TextInput::make('UK')
                            ->label('Usia Kehamilan ')
                            ->placeholder('minggu/hari')
                            ->required()
                            ->disabled()
                            ->columnSpan('2'),
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
                        TextInput::make('lila')
                            ->label('Lingkar Lengan ')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Pemeriksaan fisik')
                    ->schema([
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
                        TextInput::make('TDSI')
                            ->label('Tekanan darah sistolik')
                            ->placeholder('mmHg')
                            ->required(),
                        // ->columnSpan('1'),
                        TextInput::make('TDDI')
                            ->label('Tekanan darah diastolik')
                            ->placeholder('mmHg')
                            ->required(),
                        // Forms\Components\TextInput::make('HB')
                        //     ->label('hemoglobin')
                        //     ->placeholder('g/dl')
                        //     ->numeric()
                        //     ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
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
                            ->placeholder('Dosisi obat'),
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

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan hasil pemeriksaan')
            ->recordTitleAttribute('ibu_hamil.nama')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Jadwal posyandu')
                    // ->searchable()
                    ->date()
                    ->sortable(),
                TextColumn::make('UK')
                    ->label('usia kehamilan')
                    // ->searchable()
                    ->sortable(),
                TextColumn::make('BB')
                    ->label('Berat badan')
                    // ->searchable()
                    ->sortable(),
                TextColumn::make('TB')
                    ->label('Tinggi badan')
                    // ->searchable()
                    ->sortable(),
                TextColumn::make('lila')
                    ->label('Lingkar lengan')
                    // ->searchable()
                    ->sortable(),
                // Tables\Columns\IconColumn::make('bukuKIA')
                //     ->label('buku KIA'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
            ])
            ->actions([
                ViewAction::make()->label('Detail'),
                EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
    public  function infolist(Infolist $infolist): Infolist
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
                        //     ->label('nama')
                        //     ->color('warning'),
                        // TextEntry::make('ibu_hamil.nik')->label('NIK')->color('warning'),
                        TextEntry::make('BB')->label('Berat badan')->color('warning'),
                        TextEntry::make('TB')->label('Tinggi badan')->color('warning'),
                        TextEntry::make('lila')->label('Lingkar lengan')->color('warning'),
                        TextEntry::make('UK')->label('Usia kehamilan')->color('warning'),
                        TextEntry::make('BB')->label('Berat badan')->color('warning'),
                        TextEntry::make('TB')->label('Tinggi badan')->color('warning'),
                        // TextEntry::make('TD')->label('Tekanan darah')->default('-')->color('warning'),
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
                            ->size(IconEntry\IconEntrySize::Medium),
                    ])->columns('3'),
            ]);
    }
}
