<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum BookingStatus: string implements HasColor
{
    case Pending = 'Pending';
    case Booked = 'Booked';
    case CheckedIn = 'Checked In';
    case CheckedOut = 'Checked Out';
    case CANCELLED = 'cancelled';

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Booked => 'primary',
            self::CheckedIn => 'success',
            self::CheckedOut => 'info',
            self::CANCELLED => 'danger',
        };
    }
}
