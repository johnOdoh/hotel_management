<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum RoomStatus: string implements HasColor
{
    case Open = 'Open';
    case Locked = 'Locked'; 
    case UnderMaintenance = 'Under Maintenance';

    public function getColor(): string
    {
        return match ($this) {
            self::Open => 'success',
            self::Locked => 'danger',
            self::UnderMaintenance => 'warning',
        };
    }
}
