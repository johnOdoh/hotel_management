<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Bookings';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()
                    ->with('room.category')
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Guest')
                    ->searchable()
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('room.number')
                    ->label('Room')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('room.category.name')
                    ->label('Category')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('check_in')
                    ->label('Check-In')
                    ->date('M d, Y'),
                Tables\Columns\TextColumn::make('check_out')
                    ->label('Check-Out')
                    ->date('M d, Y'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('NGN')
                    ->sortable()
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('booking_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Online' => 'info',
                        'Walk In' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_completed')
                    ->label('Completed')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
            ])
            ->paginated(false);
    }
}
