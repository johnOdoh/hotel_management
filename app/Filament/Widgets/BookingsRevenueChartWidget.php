<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class BookingsRevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'Monthly Bookings & Revenue';

    protected ?string $description = 'Booking volume and revenue trends over the last 12 months';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected string $color = 'primary';

    protected ?string $maxHeight = '320px';

    protected function getFilters(): ?array
    {
        return [
            'bookings' => 'Booking Count',
            'revenue' => 'Revenue (₦)',
        ];
    }

    protected function getData(): array
    {
        $months = collect(range(11, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);

            return [
                'label' => $date->format('M Y'),
                'year' => (int) $date->format('Y'),
                'month' => (int) $date->format('n'),
            ];
        });

        $bookingsByMonth = Booking::selectRaw('YEAR(created_at) as yr, MONTH(created_at) as mo, count(*) as total_bookings, sum(amount) as total_revenue')
            ->whereDate('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupByRaw('yr, mo')
            ->get()
            ->keyBy(fn ($row) => "{$row->yr}-{$row->mo}");

        $labels = [];
        $bookingCounts = [];
        $revenues = [];

        foreach ($months as $month) {
            $key = "{$month['year']}-{$month['month']}";
            $row = $bookingsByMonth->get($key);

            $labels[] = $month['label'];
            $bookingCounts[] = $row?->total_bookings ?? 0;
            $revenues[] = round((float) ($row?->total_revenue ?? 0), 2);
        }

        $filter = $this->filter ?? 'bookings';

        if ($filter === 'revenue') {
            return [
                'datasets' => [
                    [
                        'label' => 'Revenue (₦)',
                        'data' => $revenues,
                        'borderColor' => 'rgb(16, 185, 129)',
                        'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                        'fill' => true,
                        'tension' => 0.4,
                        'pointBackgroundColor' => 'rgb(16, 185, 129)',
                        'pointBorderColor' => '#fff',
                        'pointBorderWidth' => 2,
                        'pointRadius' => 5,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        // Default: show both on same chart
        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $bookingCounts,
                    'borderColor' => 'rgb(99, 102, 241)',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'yAxisID' => 'y',
                    'pointBackgroundColor' => 'rgb(99, 102, 241)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                ],
                [
                    'label' => 'Revenue (₦)',
                    'data' => $revenues,
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0)',
                    'fill' => false,
                    'tension' => 0.4,
                    'yAxisID' => 'y1',
                    'pointBackgroundColor' => 'rgb(16, 185, 129)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        $filter = $this->filter ?? 'bookings';

        $scales = $filter === 'revenue'
            ? [
                'y' => [
                    'ticks' => [
                        'callback' => "function(value) { return '₦' + value.toLocaleString(); }",
                    ],
                    'grid' => ['color' => 'rgba(156, 163, 175, 0.1)'],
                ],
            ]
            : [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'ticks' => ['stepSize' => 1],
                    'grid' => ['color' => 'rgba(156, 163, 175, 0.1)'],
                    'title' => ['display' => true, 'text' => 'Bookings'],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'ticks' => [
                        'callback' => "function(value) { return '₦' + value.toLocaleString(); }",
                    ],
                    'grid' => ['drawOnChartArea' => false],
                    'title' => ['display' => true, 'text' => 'Revenue (₦)'],
                ],
            ];

        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => $scales,
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
