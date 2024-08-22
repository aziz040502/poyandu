<?php

namespace App\Filament\Resources\BalitaResource\Pages;

use App\Filament\Resources\BalitaResource;
use App\Imports\BalitaImport;
use App\Models\balita;
use Filament\Actions;
use filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;



class ListBalitas extends ListRecords
{
    protected static string $resource = BalitaResource::class;
    protected static ?string $modelLabel = 'balita';


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
                ->badge(balita::query()->where('created_at', '>=', now()->subMonth())->count()),
            'beak lauk' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 3))
                ->badge(balita::query()->where('dusun_id', 3)->count()),
            'jorong daya' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 4))
                ->badge(balita::query()->where('dusun_id', 4)->count()),
            'terutuk' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 5))
                ->badge(balita::query()->where('dusun_id', 5)->count()),
            'baret orong' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 7))
                ->badge(balita::query()->where('dusun_id', 7)->count()),
            'beak daya' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 8))
                ->badge(balita::query()->where('dusun_id', 8)->count()),
            'jorong lauk' => Tab::make()->query(fn ($query) => $query->where('dusun_id', 11))
                ->badge(balita::query()->where('dusun_id', 11)->count()),
        ];
    }
}
