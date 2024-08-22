<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\balita;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Periksabalita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\periksalansia;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Filament\Widgets\newperiksa;
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
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\Summarizers\Range;
use App\Filament\Exports\PeriksabalitaExporter;
use App\Filament\Imports\PeriksabalitaImporter;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Summarizer;
use App\Filament\Resources\PeriksabalitaResource\Pages;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Resources\PeriksabalitaResource\Pages\EditPeriksabalita;
use App\Filament\Resources\PeriksabalitaResource\Pages\ListPeriksabalitas;
use App\Filament\Resources\PeriksabalitaResource\Pages\CreatePeriksabalita;

class PeriksabalitaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Periksabalita::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'balita';
    protected static ?string $modelLabel = 'pemeriksaan  balita';
    protected static ?string $navigationGroup = 'pemeriksaan';
    // protected static ?string $recordTitleAttribute = 'balita_id';
    public static function getPluralLabel(): string
    {
        return __('pemeriksaan balita');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Select::make('balita_id')
                            ->relationship('balita', 'nama',)
                            ->searchable(['nama', 'nik'])
                            ->required()
                            ->columnSpan('2')
                            ->placeholder('masukkan nama/nik')
                            ->reactive()
                            ->afterStateUpdated(
                                function (Get $get, Set $set) {
                                    $balita = \App\Models\balita::find($get('balita_id'));
                                    if ($balita) {
                                        $set('tanggal_lahir', $balita->TTL);
                                        $set('usia', Carbon::parse($balita->TTL)->age);
                                    }
                                }
                            ),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->native(false)
                            ->disabled()
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateHydrated(function (Get $get, Set $set, ?Periksabalita $record) {
                                if ($record && $record->balita) {
                                    $set('tanggal_lahir', $record->balita->TTL);
                                }
                            }),
                        TextInput::make('usia')
                            ->label('Usia')
                            ->placeholder('Tahun')
                            ->disabled()
                            ->dehydrated(true)
                            ->reactive()
                            ->afterStateHydrated(function (Get $get, Set $set, $record) {
                                if ($record) {
                                    $set('usia', Carbon::parse($record->balita->TTL)->age);
                                }
                            }),
                        TextInput::make('TB')
                            ->label('tinggi badan')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $set('status', self::calculateStatus($get('usia'), $get('TB')));
                            }),
                        TextInput::make('BB')
                            ->label('berat badan')
                            ->placeholder('kg')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $result = self::calculateberat((int)$get('usia'), (float)$get('BB'));
                                $set('weight_status', $result['weight_status']);
                            }),
                        TextInput::make('status')
                            ->required()
                            ->disabled()
                            ->dehydrated(true),
                        // ->default(fn(Get $get) => self::calculateStatus($get('usia'), $get('tinggi'))),
                        TextInput::make('lila')
                            ->label('Lingkar Lengan')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        TextInput::make('lika')
                            ->label('Lingkar kepala')
                            ->placeholder('cm')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                        Select::make('vitamin')
                            ->options([
                                'vitamin A' => 'vitamin A',
                                'vitamin B' => 'vitamin B',
                                'vitamin M' => 'vitamin M',
                            ])
                            // ->required()
                            ->columnSpan('2'),
                        TextInput::make('obat cacing')
                            // ->required()
                            ->placeholder('dosis')
                            ->maxLength(255)
                            ->columnSpan('1'),
                        TextInput::make('imunisasi')
                            // ->required()
                            ->placeholder('vaksin')
                            ->maxLength(255)
                            ->columnSpan('1'),
                        TextInput::make('rujukan')
                            ->placeholder('keterangan')
                            ->maxLength(255)
                            ->columnSpan('1'),
                        TextInput::make('PMTpemulihan')
                            ->label('PMTpemulihan')
                            ->placeholder('PMT yang diberikan')
                            ->maxLength(255)
                            ->columnSpan('1'),
                        Toggle::make('menyusuidini')
                            ->label('inisiasi menyusui dini')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                        Toggle::make('is_visible')
                            ->label('memiliki buku KIA')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                    ])->columns(3),
            ]);
    }


    protected static function calculateStatus($age, $height): string
    {
        if ($age == 1) {
            if ($height >= 70 && $height <= 78) {
                return 'normal';
            } elseif ($height < 70) {
                return 'stunting';
            } else {
                return 'diatas normal';
            }
        } elseif ($age >= 2 && $age <= 3) {
            if ($height >= 80 && $height <= 95) {
                return 'normal';
            } elseif ($height < 80) {
                return 'stunting';
            } else {
                return 'diatas normal';
            }
        } elseif ($age >= 4 && $age <= 5) {
            if ($height >= 82 && $height <= 97) {
                return 'normal';
            } elseif ($height < 82) {
                return 'stunting';
            } else {
                return 'diatas normal';
            }
        } else {
            return 'usai tidak terdata';
        }
    }

    private static function calculateberat(int $age, float $weight): array
    {
        $status = '';
        $ranges = [
            1 => [7, 12],
            2 => [9, 15],
            3 => [11, 18],
            4 => [12, 21],
            5 => [14, 24],
        ];

        if (isset($ranges[$age])) {
            [$min, $max] = $ranges[$age];
            if ($weight < $min) {
                $status = 'kekurangan berat';
            } elseif ($weight > $max) {
                $status = 'kelebihan berat';
            } else {
                $status = 'Normal';
            }
        } else {
            $status = 'tidak di ketahui';
        }

        return [
            'weight_status' => $status,
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            $data['usia'] = Carbon::parse($data['tanggal_lahir'])->age;
        } catch (\Exception $e) {

            $data['usia'] = null;
        }
        return $data;
    }
    public static function mutateFormDataBeforeSave(array $data): array
    {
        try {
            $data['usia'] = Carbon::parse($data['tanggal_lahir'])->age;
        } catch (\Exception $e) {
            $data['usia'] = null;
        }
        return $data;
    }








    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan hasil pemeriksaan')
            ->columns([
                Tables\Columns\TextColumn::make('balita.nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('usia')
                    ->label('Usia')
                    ->numeric()
                    ->suffix('  Tahun')
                    ->sortable(),
                TextColumn::make('BB')
                    ->label('berat badan')
                    ->searchable()
                    ->sortable()
                    ->suffix(' Kg')
                    ->color(function ($record) {
                        $age = Carbon::parse($record->balita->TTL)->age;
                        $weight = $record->BB;

                        $status = self::calculateberat($age, $weight)['weight_status'];

                        return match ($status) {
                            'kekurangan berat' => 'danger',
                            'kelebihan berat' => 'warning',
                            'Normal' => 'success',
                            default => 'primary',
                        };
                    })
                    ->description(function ($record) {
                        $age = Carbon::parse($record->balita->TTL)->age;
                        $weight = $record->BB;

                        $status = self::calculateberat($age, $weight)['weight_status'];

                        return match ($status) {
                            'kekurangan berat' => 'kekurangan berat',
                            'kelebihan berat' => 'kelebihan berat',
                            'Normal' => 'normal',
                            default => 'data tidak di ketahui',
                        };
                    })
                    ->summarize(
                        Summarizer::make()
                            ->label('Berat normal')
                            ->placeholder("1-2thn(9-14 kg),2-4thn(10-17kg)")
                    ),
                TextColumn::make('TB')
                    ->label('tinggi badan')
                    ->searchable()
                    ->sortable()
                    ->suffix(' Cm')
                    ->color(fn($record): string => match ($record->status) {
                        'normal' => 'success',
                        'stunting' => 'danger',
                        'diatas normal' => 'warning',
                        default => 'primary',
                    })
                    // ->description(fn($record): string => match (true) {
                    //     $record->TB > 85 => 'tinggi di atas normal',
                    //     $record->TB == 85 => 'Berat normal',
                    //     $record->TB < 85 => 'Kekurangan tinggi',
                    //     // default => '',
                    // })
                    ->summarize(
                        Summarizer::make()
                            ->label('Tinggi normal')
                            ->placeholder('1 thn(70-78cm),2-3thn(80-95cm),4-5thn(82-97cm)')
                    ),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'normal' => 'success',
                        'stunting' => 'danger',
                        'diatas normal' => 'warning',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                TextColumn::make('lila')
                    ->label('lingkar lengan')
                    ->searchable()
                    ->sortable()
                    ->suffix(' Cm'),
                // ->summarize(
                //     Summarizer::make()
                //         ->label('Lingkar lengan normal')
                //         ->placeholder('1-2 tahun(13-17 cm), 2-4 tahun(14-18 cm)')
                // ),
                TextColumn::make('lika')
                    ->label('lingkar kepala')
                    ->searchable()
                    ->sortable()
                    ->suffix(' Cm'),
                // ->summarize(
                //     Summarizer::make()
                //         ->label('Lingkar kepala normal')
                //         ->placeholder('1-2 tahun(45-49 cm), 2-4 tahun(47-52 cm)')
                // ),
                // TextColumn::make('vitamin')
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
            ->actions([
                ViewAction::make()->label('Detail'),
                EditAction::make()->label('ubah'),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(PeriksabalitaImporter::class)
                    ->label('import')
                    ->color('success')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('import_periksabalita')),
                ExportAction::make()
                    ->exporter(periksabalitaExporter::class)
                    ->label('Export semua')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_periksabalita')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus'),
                ]),
                ExportBulkAction::make()
                    ->exporter(periksabalitaExporter::class)
                    ->label('Export item')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_periksabalita')),
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
                    ])->columns('2'),
                Section::make()
                    ->schema([
                        TextEntry::make('balita.nama')
                            ->label('nama balita')
                            ->color('warning'),
                        TextEntry::make('balita.nik')->label('NIK')->color('warning'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    // public static function getWidgets(): array
    // {
    //     return [
    //         newperiksa::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => ListPeriksabalitas::route('/'),
            'create' => CreatePeriksabalita::route('/create'),
            // 'view' => Pages\ViewPeriksabalitas::route('/{record}'),
            'edit' => EditPeriksabalita::route('/{record}/edit'),
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
