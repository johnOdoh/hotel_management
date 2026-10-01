<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum EmploymentStatus: string implements HasColor
{
    case Active = 'Active';
    case Resigned = 'Resigned';
    case Terminated = 'Terminated';

    public function getColor(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Resigned => 'primary',
            self::Terminated => 'danger',
        };
    }
}