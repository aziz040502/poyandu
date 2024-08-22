<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PeriksabalitaResource;
// use App\Filament\Resources\PeriksaibuhamilResource;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class newperiksa extends BaseWidget
{
    // protected static ?string $title = 'pemeriksaan baru';
    protected static ?string $heading = 'history pemeriksaan balita';
    protected static ?int $sort = 4;
    public function table(Table $table): Table
    {
        return $table
            ->query(PeriksabalitaResource::getEloquentQuery())
            // ->query(PeriksaibuhamilResource::getEloquentQuery())
            // ->query(PeriksalansiaResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('jadwal periksa')
                    // ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('balita.nama')
                    ->label('nama')
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('balita.nik')
                    ->label('nik')
                    // ->searchable()
                    ->sortable(),


            ]);
    }
}
