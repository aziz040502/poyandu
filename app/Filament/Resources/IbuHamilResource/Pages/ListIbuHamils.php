<?php

namespace App\Filament\Resources\IbuHamilResource\Pages;

use App\Filament\Resources\IbuHamilResource;
use App\Models\ibuhamil;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListIbuHamils extends ListRecords
{
    protected static string $resource = IbuHamilResource::class;

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
                ->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subMonth()))
                ->badge(ibuhamil::query()->where('created_at', '>=', now()->subMonth())->count()),
            'beak lauk' => Tab::make()->query(fn($query) => $query->where('dusun_id', 3))
                ->badge(ibuhamil::query()->where('dusun_id', 3)->count()),
            'jorong daya' => Tab::make()->query(fn($query) => $query->where('dusun_id', 4))
                ->badge(ibuhamil::query()->where('dusun_id', 4)->count()),
            'terutuk' => Tab::make()->query(fn($query) => $query->where('dusun_id', 5))
                ->badge(ibuhamil::query()->where('dusun_id', 5)->count()),
            'baret orong' => Tab::make()->query(fn($query) => $query->where('dusun_id', 7))
                ->badge(ibuhamil::query()->where('dusun_id', 7)->count()),
            'beak daya' => Tab::make()->query(fn($query) => $query->where('dusun_id', 8))
                ->badge(ibuhamil::query()->where('dusun_id', 8)->count()),
            'jorong lauk' => Tab::make()->query(fn($query) => $query->where('dusun_id', 11))
                ->badge(ibuhamil::query()->where('dusun_id', 11)->count()),
        ];
    }
}
