<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Hotel Dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\HotelStatsWidget::class,
            \App\Filament\Widgets\BookingsRevenueChartWidget::class,
            \App\Filament\Widgets\BookingTypeRoomStatusChartWidget::class,
            \App\Filament\Widgets\RoomCategoryRevenueChartWidget::class,
            \App\Filament\Widgets\LatestBookingsWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}
