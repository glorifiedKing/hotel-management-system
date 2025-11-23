<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'Revenue Trends (Last 7 Days)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M d');

            $revenue = Invoice::whereDate('issue_date', $date)
                ->where('status', 'paid')
                ->sum('total_amount');

            $data[] = $revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
