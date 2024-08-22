<?php

namespace App\Filament\Resources\LansiaResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
// use Filament\Forms\Components\Section;
// use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;


class PeriksalansiasRelationManager extends RelationManager
{
    protected static string $relationship = 'periksalansias';
    protected static ?string $title = 'Periksa lansia';
    protected static ?string $modelLabel = 'Hasil Pemeriksaan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            // Forms\Components\Section::make()
            //     ->schema([
            //         // Forms\Components\Select::make('lansia_id')
            //         //     ->relationship('lansia', 'nama',)
            //         //     ->label('Nama Lansia')
            //         //     ->searchable()
            //         //     ->required()
            //         //     ->columnSpan('2')
            //         //     ->reactive(),
            //     ])->columns(2),
            Forms\Components\Section::make('Status gizi')
                    ->schema([
                        Forms\Components\TextInput::make('BB')
                            ->label('Berat badan ')
                            ->placeholder('kg')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        Forms\Components\TextInput::make('TB')
                            ->label('Tinggi badan ')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        Forms\Components\TextInput::make('LP')
                            ->label('Lingkar perut')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                    ])->columns(3),

            Forms\Components\Section::make('tanda vital')
                    ->schema([
                        Forms\Components\TextInput::make('TDSI')
                            ->label('Tekanan darah sistolik')
                            ->placeholder('mmHg')
                            ->required()
                            ->columnSpan('1'),
                        Forms\Components\TextInput::make('TDDI')
                            ->label('Tekanan darah diastolik')
                            ->placeholder('mmHg')
                            ->required()
                            ->columnSpan('1'),
                        Forms\Components\TextInput::make('nadi')
                            ->label('NADI')
                            ->placeholder('bpm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                    ])->columns(2),
            Forms\Components\Section::make('Pemeriksaan LAB')
                    ->schema([
                        Forms\Components\TextInput::make('GD')
                            ->label('Gula darah')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        Forms\Components\TextInput::make('AS')
                            ->label('Asam urat')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        Forms\Components\TextInput::make('CHOL')
                            ->label('colestrol')
                            ->placeholder('mg/dl')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                    ])->columns('3'),
                Forms\Components\Section::make('Mental emosional')
                    ->schema([
                        Forms\Components\TextInput::make('GEP')
                            ->label('Gangguan emosi/prilaku')
                            ->placeholder('keterangan')
                        // ->placeholder('TT')
                        ,
                        Forms\Components\TextInput::make('SGDS')
                            ->label('Sekor GDS')
                            ->numeric()
                            ->placeholder('0-30'),
                        Forms\Components\TextInput::make('koghnitif')
                            // ->label('s')
                            ->numeric()
                            ->placeholder('0-30'),
                        Forms\Components\TextInput::make('AMT')
                            ->label('Tes Mental Singkat')
                            ->numeric()
                            ->placeholder('0-10'),
                    ])->columns('2'),
                Forms\Components\Section::make('Mental emosional')
                    ->schema([
                        Forms\Components\TextInput::make('RJ')
                            ->label('Risiko jatuh')
                            ->numeric()
                            ->placeholder('%'),
                        Forms\Components\TextInput::make('ADL')
                            ->label('Aktifitas sehari-hari')
                            ->placeholder('kegiatan'),
                        Forms\Components\Select::make('kemandirian')
                            ->options([
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                            ])
                    ])->columns('3'),
                Forms\Components\Section::make('Gangguan Fisik')
                    ->schema([
                        Forms\Components\TextInput::make('kencing')
                            ->label('Kencing')
                            ->placeholder('keterangan'),
                        Forms\Components\TextInput::make('mata')
                            ->label('Pengelihatan')
                            ->placeholder('keterangan'),
                        Forms\Components\TextInput::make('telinga')
                            ->label('pendengaran')
                            ->placeholder('keterangan'),
                    ])->columns('3'),
            ])->columns('2');
    }

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan hasil pemeriksaan')
            ->recordTitleAttribute('lansia.nama')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Jadwal posyandu')
                    ->searchable()
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('BB')
                    ->label('Berat badan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('TB')
                    ->label('Tinggi badan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('LP')
                    ->label('Lingkar perut')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('TDSI')
                    ->label('Tekanan darah sistolik')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('TDDI')
                    ->label('Tekanan darah diastolik')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Detail'),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public  function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Data Lansia')
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
                Section::make('Hasil Pemeriksaan')
                    ->schema([
                // TextEntry::make('lansia.nama')
                //     ->label('nama')
                //     ->color('warning'),
                // TextEntry::make('lansia.nik')->label('NIK')->color('warning'),
                TextEntry::make('BB')->label('Berat badan')->color('warning'),
                TextEntry::make('TB')->label('Tinggi badan')->color('warning'),
                TextEntry::make('LP')->label('Lingkar perut')->color('warning'),
                TextEntry::make('TDSI')->label('tekanan darah sistolik')->color('warning'),
                TextEntry::make('TDDI')->label('tekanan darah diastolik')->color('warning'),
                TextEntry::make('nadi')->label('Berat badan')->color('warning'),
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
            ])->columns('3');
    }
}
