<?php

namespace App\Filament\Widgets;

use App\Models\balita;
use App\Models\ibu_hamil;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use App\Models\Treatment;
use Flowframe\Trend\TrendValue;

class statsadmin extends ChartWidget
{
    protected static ?string $heading = 'jumlah data balita perbulan';
    protected static string $color = 'success';
    protected static ?string $pollingInterval = '5s';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = Trend::model(balita::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        // dd($data);
        return [
            'datasets' => [
                [
                    'label' => 'balita',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
