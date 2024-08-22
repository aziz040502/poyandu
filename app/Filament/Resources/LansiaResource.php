<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Lansia;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\TextInput;
use Filament\Actions\ViewAction;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use App\Filament\Exports\LansiaExporter;
use App\Filament\Imports\LansiaImporter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\LansiaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LansiaResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class LansiaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Lansia::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Lansia';
    protected static ?string $modelLabel = 'daftar Lansia';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationGroup = 'Data peserta';
    public static function getPluralLabel(): string
    {
        return __('lansia');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->placeholder('Masukkan Nama Lengkap')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('nik')
                            ->unique(ignoreRecord: true)
                            ->minLength(16)
                            ->maxLength(16)
                            // ->tel()
                            ->label('Nomer Induk Kependudukan')
                            ->placeholder('Masukkan Nomer NIK Anda')
                            ->required(),
                        Forms\Components\DatePicker::make('TTL')
                            ->native(false)
                            ->required()
                            ->label('Tanggal Lahir')
                            ->maxDate(now()),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'laki-laki' => 'laki-laki',
                                'perempuan' => 'perempuan',
                            ])
                            ->required()
                            ->label('Jenis Kelamin'),
                        Forms\Components\Select::make('dusun_id')
                            ->relationship('dusun', 'name')
                            ->required(),
                    ])->columns('2'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan data lansia')
            ->columns([
                // TextColumn::make('no')->state(
                //     static function (HasTable $livewire, \stdClass $rowLoop): string {
                //         return (string) (
                //             $rowLoop->iteration +
                //             ($livewire->getTableRecordsPerPage() * (
                //                 $livewire->getTablePage() - 1
                //             ))
                //         );
                //     }
                // ),
                TextColumn::make('nama')->sortable()->searchable(),
                TextColumn::make('nik')->sortable()->searchable(),
                TextColumn::make('TTL')
                    ->label('Tanggal lahir')
                    ->date(),
                TextColumn::make('gender'),
                // TextColumn::make('ayah')->searchable(),
                // TextColumn::make('ibu')->searchable(),
                TextColumn::make('dusun.name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Detail'),
                Tables\Actions\EditAction::make()->label('ubah'),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(LansiaImporter::class)
                    ->label('import')
                    ->color('success')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('import_lansia')),
                ExportAction::make()
                    ->exporter(LansiaExporter::class)
                    ->label('export semua')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_lansia')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus'),
                ]),
                ExportBulkAction::make()
                    ->exporter(LansiaExporter::class)
                    ->label('Export item')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => Auth::check() && Gate::allows('export_lansia')),
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
                        TextEntry::make('TTL')->label('Tanggal Lahir')->color('warning')->date(),
                        TextEntry::make('gender')->color('warning'),
                        TextEntry::make('dusun.name')->color('warning'),
                    ])->columns('2'),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PeriksalansiasRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLansias::route('/'),
            'create' => Pages\CreateLansia::route('/create'),
            'edit' => Pages\EditLansia::route('/{record}/edit'),
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
