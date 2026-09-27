<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RoomStatus: string implements HasColor, HasLabel
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

    public function getLabel(): string
    {
        return match ($this) {
            self::Open => 'Open',
            self::Locked => 'Locked',
            self::UnderMaintenance => 'Under Maintenance',
        };
    }
}
