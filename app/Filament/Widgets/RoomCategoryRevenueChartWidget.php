<?php

namespace App\Filament\Widgets;

use App\Models\RoomCategory;
use Filament\Widgets\ChartWidget;

class RoomCategoryRevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'Revenue by Room Category';

    protected ?string $description = 'Total revenue earned per room category';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 1,
    ];

    protected string $color = 'success';

    protected ?string $maxHeight = '280px';

    protected function getData(): array
    {
        // Aggregate revenue and bookings from bookings table joined via rooms
        $data = RoomCategory::select('room_categories.id', 'room_categories.name')
            ->selectRaw('COALESCE(SUM(bookings.amount), 0) as total_revenue')
            ->selectRaw('COUNT(DISTINCT bookings.id) as total_bookings')
            ->leftJoin('rooms', 'rooms.room_category_id', '=', 'room_categories.id')
            ->leftJoin('bookings', 'bookings.room_id', '=', 'rooms.id')
            ->groupBy('room_categories.id', 'room_categories.name')
            ->get();

        $labels = $data->pluck('name')->toArray();
        $revenues = $data->map(fn ($item) => round((float) $item->total_revenue, 2))->toArray();
        $bookingCounts = $data->pluck('total_bookings')->toArray();

        $colors = [
            'rgba(99, 102, 241, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(168, 85, 247, 0.8)',
            'rgba(14, 165, 233, 0.8)',
        ];

        $borderColors = [
            'rgb(99, 102, 241)',
            'rgb(16, 185, 129)',
            'rgb(245, 158, 11)',
            'rgb(239, 68, 68)',
            'rgb(168, 85, 247)',
            'rgb(14, 165, 233)',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (₦)',
                    'data' => $revenues,
                    'backgroundColor' => array_slice($colors, 0, count($labels)),
                    'borderColor' => array_slice($borderColors, 0, count($labels)),
                    'borderWidth' => 2,
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) { return ' ₦' + context.raw.toLocaleString('en-NG', {minimumFractionDigits: 2}); }",
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => "function(value) { return '₦' + value.toLocaleString(); }",
                    ],
                    'grid' => ['color' => 'rgba(156, 163, 175, 0.1)'],
                ],
                'x' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
