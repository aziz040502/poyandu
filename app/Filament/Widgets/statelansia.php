<?php

namespace App\Filament\Widgets;

use App\Models\lansia;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use App\Models\Treatment;
use Flowframe\Trend\TrendValue;

class statelansia extends ChartWidget
{
    // protected int | string | array $columnSpan = '1';
    protected static ?string $heading = 'jumlah data lansia perbulan';
    protected static string $color = 'warning';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Trend::model(lansia::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'lansia',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
