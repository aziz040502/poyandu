<?php

namespace App\Filament\Widgets;

use App\Models\ibuhamil;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use App\Models\Treatment;
use Flowframe\Trend\TrendValue;


class stateibuhamil extends ChartWidget
{
    protected static ?string $heading = 'jumlah data ibu hamil perbulan';
    protected static string $color = 'info';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::model(ibuhamil::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'ibu hamil',
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
