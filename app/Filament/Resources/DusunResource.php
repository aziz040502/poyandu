<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Dusun;
use Filament\Forms\Form;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\DusunResource\Pages;
use App\Filament\Resources\DusunResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class DusunResource extends Resource implements HasShieldPermissions
{
    public static function getPluralLabel(): string
    {
        return __('dusun');
    }
    protected static ?string $model = Dusun::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'dusun';
    protected static ?string $modelLabel = 'daftar dusun';
    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('dusun')
                    ->maxLength(255)
                    ->required()
                    ->unique(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('tidak ada data')
            ->emptyStateDescription('masukkan data dusun')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('dusun'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->label('ubah'),
                // DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus'),
                ]),
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
            'index' => Pages\ListDusuns::route('/'),
            'created' => Pages\CreateDusun::route('/create'),
            'edit' => Pages\EditDusun::route('/{record}/edit'),
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
        ];
    }
    
}
