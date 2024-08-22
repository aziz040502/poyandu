<?php

namespace App\Filament\Resources\PeriksabalitaResource\Widgets;

use App\Models\periksabalita;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class datastuntingChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'datastuntingChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Jumlah Balita berpotensi stunting';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $data = periksabalita::where('status', 'stunting')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Prepare the series data for the chart
        $seriesData = [];
        for ($month = 1; $month <= 12; $month++) {
            $seriesData[] = $data[$month] ?? 0;
        }
        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'balita',
                    'data' => $seriesData,
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#DC3545'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
        ];
    }
}
