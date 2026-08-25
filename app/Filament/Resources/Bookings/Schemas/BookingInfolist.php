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
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('room_id')
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('phone'),
                TextEntry::make('check_in')
                    ->date(),
                TextEntry::make('check_out')
                    ->date(),
                TextEntry::make('number_of_guests')
                    ->numeric(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('booking_type'),
                TextEntry::make('is_completed')
                    ->numeric(),
                TextEntry::make('booked_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
