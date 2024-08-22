<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\IbuHamil;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Filament\Forms\Components\Select;
use function Laravel\Prompts\warning;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\IbuHamilExporter;
use App\Filament\Imports\IbuHamilImporter;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\IbuHamilResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\IbuHamilResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Resources\IbuHamilResource\RelationManagers\PeriksaibuhamilsRelationManager;

class IbuHamilResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = IbuHamil::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Ibu Hamil';
    protected static ?string $modelLabel = 'daftar Ibu Hamil';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationGroup = 'Data peserta';

    public static function getPluralLabel(): string
    {
        return __('ibu hamil');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Ibu')
                            ->required()
                            ->placeholder('Masukkan Nama Lengkap')
                            ->maxLength(50),
                        TextInput::make('suami')
                            ->required()
                            ->dehydrateStateUsing(fn($state) => ucwords($state))
                            ->label('Nama Suami')
                            ->placeholder('Masukkan nama lengkap')
                            ->maxLength(50),
                        TextInput::make('nik')
                            ->unique(ignoreRecord: true)
                            ->minLength(16)
                            ->maxLength(16)
                            ->label('Nomer Induk Kependudukan')
                            ->placeholder('Masukkan Nomer NIK Anda')
                            ->required(),
                        DatePicker::make('TTL')
                            ->required()
                            ->native(false)
                            ->label('Tanggal Lahir')
                            ->maxDate(now()),
                        Select::make('dusun_id')
                            ->label('dusun')
                            ->relationship('dusun', 'name')
                            ->relationship('dusun', 'name')
                            ->required(),
                        DatePicker::make('HPHTB')
                            ->label('Hari Pertama Haid Terakhir')
                            ->required()
                            ->native(false)
                    ])->columns('2'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan data ibu hamil')
            ->columns([

                TextColumn::make('nama')->sortable()->searchable(),
                TextColumn::make('suami')->searchable(),
                TextColumn::make('nik')->sortable()->searchable(),
                TextColumn::make('TTL')->label('Tanggal lahir')->sortable()->date(),
                TextColumn::make('dusun.name')->searchable(),
                TextColumn::make('HPHTB')->label('Awal Haid Terakhir')->sortable()->date(),
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
                    ->importer(IbuHamilImporter::class)
                    ->label('import')
                    ->color('success')
                    ->icon('heroicon-o-arrow-up-tray'),
                    // ->visible(fn() => Auth::check() && Gate::allows('import_ibuhamil')),
                ExportAction::make()
                    ->exporter(IbuHamilExporter::class)
                    ->label('Export semua')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray')
                    // ->visible(fn() => Auth::check() && Gate::allows('export_ibuhamil')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
                ]),
                ExportBulkAction::make()
                    ->exporter(IbuHamilExporter::class)
                    ->label('Export item')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-down-tray'),
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
                            ->date()
                            ->color('warning'),
                        TextEntry::make('updated_at')
                            ->label('Tanggal diubah')
                            ->date()
                            ->color('warning'),
                    ])->columns('2'),
                Section::make()
                    ->schema([
                        TextEntry::make('nama')->color('warning'),
                        TextEntry::make('nik')->color('warning'),
                        TextEntry::make('TTL')->color('warning')->label('Tanggal lahira'),
                        TextEntry::make('suami')->color('warning'),
                        TextEntry::make('dusun.name')->color('warning'),
                    ])->columns('2'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PeriksaibuhamilsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIbuHamils::route('/'),
            'create' => Pages\CreateIbuHamil::route('/create'),
            'edit' => Pages\EditIbuHamil::route('/{record}/edit'),
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
