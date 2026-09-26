<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Room;
use Filament\Widgets\ChartWidget;

class BookingTypeRoomStatusChartWidget extends ChartWidget
{
    protected ?string $heading = 'Booking Type & Room Status';

    protected ?string $description = 'Distribution of booking channels and current room availability';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 1,
    ];

    protected string $color = 'warning';

    protected ?string $maxHeight = '280px';

    protected function getFilters(): ?array
    {
        return [
            'booking_type' => 'Booking Type',
            'room_status' => 'Room Status',
            'booking_status' => 'Booking Status',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'booking_type';

        if ($filter === 'room_status') {
            $statuses = Room::selectRaw('status, count(*) as cnt')
                ->groupBy('status')
                ->pluck('cnt', 'status')
                ->toArray();

            return [
                'datasets' => [
                    [
                        'data' => array_values($statuses),
                        'backgroundColor' => [
                            'rgba(16, 185, 129, 0.85)',   // Open - green
                            'rgba(239, 68, 68, 0.85)',    // Locked - red
                            'rgba(245, 158, 11, 0.85)',   // Under Maintenance - amber
                        ],
                        'borderColor' => [
                            'rgb(16, 185, 129)',
                            'rgb(239, 68, 68)',
                            'rgb(245, 158, 11)',
                        ],
                        'borderWidth' => 2,
                        'hoverOffset' => 8,
                    ],
                ],
                'labels' => array_keys($statuses),
            ];
        }

        if ($filter === 'booking_status') {
            $completed = Booking::where('is_completed', true)->count();
            $active = Booking::where('is_completed', false)->count();

            return [
                'datasets' => [
                    [
                        'data' => [$completed, $active],
                        'backgroundColor' => [
                            'rgba(16, 185, 129, 0.85)',
                            'rgba(99, 102, 241, 0.85)',
                        ],
                        'borderColor' => [
                            'rgb(16, 185, 129)',
                            'rgb(99, 102, 241)',
                        ],
                        'borderWidth' => 2,
                        'hoverOffset' => 8,
                    ],
                ],
                'labels' => ['Completed', 'Active'],
            ];
        }

        // Default: booking type breakdown
        $types = Booking::selectRaw('booking_type, count(*) as cnt')
            ->groupBy('booking_type')
            ->pluck('cnt', 'booking_type')
            ->toArray();

        return [
            'datasets' => [
                [
                    'data' => array_values($types),
                    'backgroundColor' => [
                        'rgba(99, 102, 241, 0.85)',   // Online
                        'rgba(245, 158, 11, 0.85)',   // Walk In
                        'rgba(16, 185, 129, 0.85)',   // Other
                        'rgba(239, 68, 68, 0.85)',
                    ],
                    'borderColor' => [
                        'rgb(99, 102, 241)',
                        'rgb(245, 158, 11)',
                        'rgb(16, 185, 129)',
                        'rgb(239, 68, 68)',
                    ],
                    'borderWidth' => 2,
                    'hoverOffset' => 8,
                ],
            ],
            'labels' => array_keys($types),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 16,
                        'usePointStyle' => true,
                    ],
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const pct = total > 0 ? Math.round((value / total) * 100) : 0;
                            return context.label + ': ' + value + ' (' + pct + '%)';
                        }",
                    ],
                ],
            ],
            'cutout' => '65%',
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
