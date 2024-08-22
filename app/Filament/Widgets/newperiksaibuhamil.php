<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PeriksaibuhamilResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class newperiksaibuhamil extends BaseWidget
{
    protected static ?string $heading = 'history pemeriksaan ibu hamil';
    protected static ?int $sort = 5;
    public function table(Table $table): Table
    {
        return $table
            ->query(PeriksaibuhamilResource::getEloquentQuery())
            // ->query(PeriksalansiaResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('jadwal periksa')
                    // ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('ibuhamil.nama')
                    ->label('nama')
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Ibuhamil.nik')
                    ->label('nik')
                    // ->searchable()
                    ->sortable(),


            ]);
    }
}
