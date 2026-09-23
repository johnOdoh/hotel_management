<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('phone'),
                TextEntry::make('room.number')
                    ->label('Room Number'),
                TextEntry::make('check_in')
                    ->date(),
                TextEntry::make('check_out')
                    ->date(),
                TextEntry::make('amount')
                    ->label('Amount(₦)')
                    ->numeric(),
                TextEntry::make('booking_type')
                    ->badge(),
                TextEntry::make('is_completed')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Completed' : 'Ongoing')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'warning'),
                TextEntry::make('user.name')
                    ->label('Booked by')
                    ->numeric()
                    ->placeholder('N/A'),
                TextEntry::make('created_at')
                    ->label('Booked On')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
