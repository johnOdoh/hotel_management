<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum BookingType: string implements HasColor
{
    case Online = 'Online';
    case Walk_In = 'Walk In';

    public function getColor(): string
    {
        return match ($this) {
            self::Online => 'success',
            self::Walk_In => 'info',
        };
    }
}
