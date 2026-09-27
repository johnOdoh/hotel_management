<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Bookings';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::with('room.category')
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Guest')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('room.number')
                    ->label('Room')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('room.category.name')
                    ->label('Category')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('check_in')
                    ->label('Check-In')
                    ->date(),
                TextColumn::make('check_out')
                    ->label('Check-Out')
                    ->date(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('NGN')
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('booking_type')
                    ->label('Type')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->paginated(false);
    }
}
