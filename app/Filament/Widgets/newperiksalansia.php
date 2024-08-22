<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PeriksalansiaResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class newperiksalansia extends BaseWidget
{
    protected static ?string $heading = 'history pemeriksaan lansia';
    protected static ?int $sort = 6;
    public function table(Table $table): Table
    {

        return $table

            ->query(PeriksalansiaResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('jadwal periksa')
                    // ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('lansia.nama')
                    ->label('nama')
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lansia.nik')
                    ->label('nik')
                    // ->searchable()
                    ->sortable(),


            ]);
    }
}
