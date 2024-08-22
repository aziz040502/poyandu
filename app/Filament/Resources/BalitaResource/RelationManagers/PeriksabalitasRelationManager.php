<?php

namespace App\Filament\Resources\BalitaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PeriksabalitaResource\Pages;
use App\Filament\Resources\PeriksabalitaResource\RelationManagers;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
// use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Components\TextInput;
// use Filament\Forms\Get;
// use Filament\Forms\Set;
// use Illuminate\Support\Str;
// use Filament\Forms\Components\Fieldset;
// use Filament\Forms\Components\Select;

class PeriksabalitasRelationManager extends RelationManager
{
    protected static string $relationship = 'Periksabalitas';
    protected static ?string $title = 'Pemeriksaan Balita';
    protected static ?string $modelLabel = 'Hasil Pemeriksaan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('balita_id')
                //     ->relationship('balita', 'nama',)
                //     ->searchable()
                //     ->required()
                //     ->columnSpan('2')
                //     ->reactive(),
                Forms\Components\TextInput::make('BB')
                    ->label('berat badan')
                    ->placeholder('kg')
                    ->numeric()
                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                    ->required(),
                Forms\Components\TextInput::make('TB')
                    ->label('tinggi badan')
                    ->placeholder('cm')
                    ->numeric()
                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                    ->required(),
                Forms\Components\TextInput::make('lila')
                    ->label('Lingkar Lengan')
                    ->placeholder('cm')
                    ->numeric()
                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                    ->required(),
                Forms\Components\TextInput::make('lika')
                    ->label('Lingkar kepala')
                    ->placeholder('cm')
                    ->numeric()
                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                    ->required(),
                Forms\Components\Select::make('vitamin')
                    ->options([
                        'vitamin A' => 'vitamin A',
                        'vitamin B' => 'vitamin B',
                        'vitamin M' => 'vitamin M',
                    ])
                    // ->required()
                    ->columnSpan('2'),
                Forms\Components\TextInput::make('obat cacing')
                    // ->required()
                    ->placeholder('dosis')
                    ->maxLength(255)
                    ->columnSpan('1'),
                Forms\Components\TextInput::make('imunisasi')
                    // ->required()
                    ->placeholder('vaksin')
                    ->maxLength(255)
                    ->columnSpan('1'),
                Forms\Components\TextInput::make('rujukan')
                    ->placeholder('maskkan keterangan rujukan')
                    ->maxLength(255)
                    ->columnSpan('1'),
                Forms\Components\TextInput::make('PMTpemulihan')
                    ->label('PMTpemulihan')
                    ->placeholder('PMT yang diberikan')
                    ->maxLength(255)
                    ->columnSpan('1'),
                Forms\Components\Toggle::make('menyusuidini')
                    ->label('inisiasi menyusui dini')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true),
                Forms\Components\Toggle::make('is_visible')
                    ->label('memiliki buku KIA')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true),

            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan hasil pemeriksaan')
            ->recordTitleAttribute('balita.nama')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('jadwal pemeriksaan')
                    // ->searchable()
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('BB')
                    ->label('berat badan')
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('TB')
                    ->label('tinggi badan')
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lila')
                    ->label('lingkar lengan')
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lika')
                    ->label('lingkar kepala')
                    // ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('vitamin')
                //     ->label('pelayanan')
                //     ->searchable()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('menyusuidini')
                //     ->label('Menyusui dini'),
                // Tables\Columns\IconColumn::make('is_visible')
                //     ->label('buku KIA'),
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
                // Tables\Acti ons\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public function infolist(Infolist $infolist): Infolist
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
                    ])->columns('2'),
                Section::make()
                    ->schema([
                        // TextEntry::make('balita.nama')
                        // ->label('nama balita')
                        // ->color('warning'),
                        // TextEntry::make('balita.nik')->label('NIK')->color('warning'),
                        TextEntry::make('BB')->label('Berat badan')->color('warning'),
                        TextEntry::make('TB')->label('Tinggi badan')->color('warning'),
                        TextEntry::make('lila')->label('Lingkar lengan')->color('warning'),
                        TextEntry::make('lika')->label('Lingkar kepala')->color('warning'),
                        TextEntry::make('vitamin')->default('-')->color('warning'),
                        TextEntry::make('imunisasi')->default('-')->color('warning'),
                        TextEntry::make('rujukan')->default('-')->color('warning'),
                        TextEntry::make('obatcacing')->label('obat cacing')->default('-')->color('warning'),
                        TextEntry::make('PMTpemulihan')->default('-')->label('PMT pemulihan')->color('warning'),
                        IconEntry::make('is_visible')
                            ->label('membawa buku KIA')
                            ->size(IconEntry\IconEntrySize::Medium),
                        IconEntry::make('menyusuidini')
                            ->label('menyusui dini')
                            ->size(IconEntry\IconEntrySize::Medium),
                    ])->columns('3'),
            ]);
    }
}
