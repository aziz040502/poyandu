<?php

namespace App\Filament\Resources;

// use Auth;
use Closure;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Set;
use Filament\Tables;
use App\Models\Balita;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
// use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use App\Filament\Exports\BalitaExporter;
use App\Filament\Imports\BalitaImporter;
use Filament\Forms\Components\TextInput;
use App\Filament\Widgets\Statsnewperiksa;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
// use Filament\Infolists\Components\Section;
// use Filament\Actions\Exports\ExportColumn;
// use App\Filament\Exports\BalitaExporter;
// use Filament\Actions\Exports\Enums\ExportFormat;
// use Filament\Tables\Actions\ExportAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
// use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\BalitaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BalitaResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Resources\BalitaResource\RelationManagers\PeriksaBalitaRelationManager;
use App\Filament\Resources\BalitaResource\RelationManagers\PeriksabalitasRelationManager;

class BalitaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Balita::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'balita';
    protected static ?string $modelLabel = 'Daftar balita';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationGroup = 'Data peserta';

    public static function getPluralLabel(): string
    {
        return __('balita');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->placeholder('Masukkan Nama Lengkap')
                            ->maxLength(50),
                        TextInput::make('nik')
                            ->unique(ignoreRecord: true)
                            ->minLength(16)
                            ->maxLength(16)
                            // ->tel()
                            ->label('Nomer Induk Kependudukan')
                            ->placeholder('Masukkan Nomer NIK Anda')
                            ->required(),
                        DatePicker::make('TTL')
                            ->label('Tanggal Lahir')
                            ->native(false)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (set $set, $state) {
                                $set('age', Carbon::parse($state)->age);
                            }),

                        TextInput::make('age')
                            ->label('Usia')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\Select::make('gender')
                            ->options([
                                'laki-laki' => 'Laki-laki',
                                'perempuan' => 'Perempuan',
                            ])
                            ->dehydrateStateUsing(fn($state) => ucwords($state))
                            ->required()
                            ->label('Jenis Kelamin'),
                        TextInput::make('ayah')
                            ->required()
                            ->dehydrateStateUsing(fn($state) => ucwords($state))
                            ->label('Nama Ayah')
                            ->placeholder('Masukkan nama lengkap')
                            ->maxLength(50),
                        TextInput::make('ibu')
                            ->required()
                            ->dehydrateStateUsing(fn($state) => ucwords($state))
                            ->label('Nama Ibu')
                            ->placeholder('Masukkan nama lengkap ')
                            ->maxLength(50),
                        Forms\Components\Select::make('dusun_id')
                            ->relationship('dusun', 'name')
                            ->dehydrateStateUsing(fn($state) => ucwords($state))
                            ->required(),
                    ])->columns('3'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            // ->modifyQueryUsing(function (Builder $query) {
            //     $userId = auth()->user()->id;
            //     $query->where('dusun_id', $userId);
            // })
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan data balita')
            ->columns([
                // Tables\Columns\TextColumn::make('no')->state(
                //     static function (HasTable $livewire, \stdClass $rowLoop): string {
                //         return (string) (
                //             $rowLoop->iteration +
                //             ($livewire->getTableRecordsPerPage() * (
                //                 $livewire->getTablePage() - 1
                //             ))
                //         );
                //     }
                // ),
                TextColumn::make('nama')->sortable()->label('Nama')->searchable(),
                TextColumn::make('nik')->sortable()->label('Nik')->searchable(),
                TextColumn::make('TTL')
                    ->label('Tanggal lahir')
                    ->date(),
                TextColumn::make('age')
                    ->label('Usia')
                    ->searchable()
                    ->suffix('  Tahun')
                    ->sortable(['TTL']),
                TextColumn::make('gender')->label('Gender')->searchable(),
                TextColumn::make('ayah')->searchable(),
                TextColumn::make('ibu')->searchable(),
                TextColumn::make('dusun.name')->searchable(),
            ])

            ->filters([
                //
            ])
            ->actions([

                ViewAction::make()
                    // ->color('success')
                    ->label('Detail'),
                EditAction::make()
                    // ->color('warning')
                    ->label('ubah'),

                // Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(BalitaImporter::class)
                    ->label('import')
                    ->color('success')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('import_balita')),
                
                ExportAction::make()
                    ->exporter(BalitaExporter::class)
                    ->label('Export semua')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_balita')),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
                ]),
                ExportBulkAction::make()
                    ->exporter(BalitaExporter::class)
                    ->label('Export item')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_balita')),
                // ->authorize('export'),
                // ExportBulkAction::make()->label('Expor'),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('created_at')->label('Tanggal ditambah')->date()->color('warning'),
                        TextEntry::make('updated_at')->label('Tanggal diubah')->date()->color('warning'),
                    ])->columns('2'),
                Section::make()
                    ->schema([
                        TextEntry::make('nama')->color('warning'),
                        TextEntry::make('nik')->color('warning'),
                        TextEntry::make('TTL')->label('Tanggal lahir')->date()->color('warning'),
                        TextEntry::make('gender')->color('warning'),
                        TextEntry::make('ayah')->color('warning'),
                        TextEntry::make('ibu')->color('warning'),
                        TextEntry::make('dusun.name')->color('warning'),
                    ])->columns('2'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PeriksabalitasRelationManager::class
        ];
    }
    // public static function getWidgets(): array
    // {
    //     return [ 
    //         Statsnewperiksa::class,
    //     ];
    // }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBalitas::route('/'),
            'create' => Pages\CreateBalita::route('/create'),
            // 'view' => Pages\ViewBalitas::route('/{record}'),
            'edit' => Pages\EditBalita::route('/{record}/edit'),
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
