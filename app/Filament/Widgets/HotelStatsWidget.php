<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Employee;
use App\Models\Room;
use App\Models\RoomCategory;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HotelStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalRevenue = Booking::sum('amount');
        $thisMonthRevenue = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $lastMonthRevenue = Booking::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('amount');

        $revenueChange = $lastMonthRevenue > 0
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : null;

        $totalBookings = Booking::count();
        $completedBookings = Booking::where('is_completed', true)->count();
        $activeBookings = Booking::where('is_completed', false)->count();

        $totalRooms = Room::count();
        $openRooms = Room::where('status', 'Open')->count();
        $maintenanceRooms = Room::where('status', 'Under Maintenance')->count();

        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('employment_status', 'Active')->count();

        // Sparkline data for the last 6 months of bookings
        $last6MonthsBookings = collect(range(5, 0))->map(function ($monthsAgo) {
            return Booking::whereMonth('created_at', now()->subMonths($monthsAgo)->month)
                ->whereYear('created_at', now()->subMonths($monthsAgo)->year)
                ->count();
        })->toArray();

        // Sparkline for revenue
        $last6MonthsRevenue = collect(range(5, 0))->map(function ($monthsAgo) {
            return (float) Booking::whereMonth('created_at', now()->subMonths($monthsAgo)->month)
                ->whereYear('created_at', now()->subMonths($monthsAgo)->year)
                ->sum('amount');
        })->toArray();

        return [
            Stat::make('Total Revenue', '₦' . number_format((float) $totalRevenue, 2))
                ->visible(auth()->user()->can('viewAny', Employee::class))
                ->description(
                    $revenueChange !== null
                        ? abs(round($revenueChange, 1)) . '% ' . ($revenueChange >= 0 ? 'increase' : 'decrease') . ' vs last month'
                        : 'All time revenue'
                )
                ->descriptionIcon($revenueChange !== null && $revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange !== null && $revenueChange >= 0 ? 'success' : 'danger')
                ->chart($last6MonthsRevenue)
                ->chartColor('success'),

            Stat::make('Total Bookings', $totalBookings)
                ->description("{$completedBookings} completed · {$activeBookings} active")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary')
                ->chart($last6MonthsBookings)
                ->chartColor('primary'),

            Stat::make('Rooms', $totalRooms)
                ->description("{$openRooms} open · {$maintenanceRooms} under maintenance")
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('warning'),

            Stat::make('Room Categories', RoomCategory::count())
                ->description('Distinct room types available')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),

            Stat::make('Employees', $totalEmployees)
                ->description("{$activeEmployees} active staff members")
                ->descriptionIcon('heroicon-m-user-group')
                ->visible(auth()->user()->can('viewAny', Employee::class))
                ->color('success'),

            Stat::make('This Month Revenue', '₦' . number_format((float) $thisMonthRevenue, 2))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
