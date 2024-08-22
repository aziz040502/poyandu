<?php

namespace App\Filament\Resources\PeriksabalitaResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\periksabalita;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Database\Eloquent\Builder;

class keterangan extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            // ->query(
            //     // periksabalita::query()
            // )
            ->query(Periksabalita::query()->whereRaw('1 = 0'))
            ->columns([
                Tables\Columns\TextColumn::make('custom_text')
                    ->label('Keterangan')
                    ->getStateUsing(fn() => 'Teks statis yang ingin Anda tampilkan')
            ]);
    }
}
