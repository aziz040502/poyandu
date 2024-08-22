<?php

namespace App\Filament\Resources\LansiaResource\Pages;

use App\Filament\Resources\LansiaResource;
use App\Models\lansia;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListLansias extends ListRecords
{
    protected static string $resource = LansiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label('Semua'),
            'baru' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subMonth()))
                ->badge(lansia::query()->where('created_at', '>=', now()->subMonth())->count()),
            'beak lauk' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 3))
                ->badge(lansia::query()->where('dusun_id', 3)->count()),
            'jorong daya' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 4))
                ->badge(lansia::query()->where('dusun_id', 4)->count()),
            'terutuk' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 5))
                ->badge(lansia::query()->where('dusun_id', 5)->count()),
            'baret orong' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 7))
                ->badge(lansia::query()->where('dusun_id', 7)->count()),
            'beak daya' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 8))
                ->badge(lansia::query()->where('dusun_id', 8)->count()),
            'jorong lauk' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 11))
                ->badge(lansia::query()->where('dusun_id', 11)->count()),
        ];
    }
}
