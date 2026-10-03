<?php

namespace App\Enums;

enum UserRole: string
{
    case OWNER = 'Owner';
    case MANAGER = 'Manager';
    case RECEPTIONIST = 'Receptionist';

    /**
     * Get selectable options excluding specific administrative roles.
     */
    public static function assignableOptions(): array
    {
        return collect(self::cases())
            ->reject(fn(self $role) => $role === self::OWNER)
            ->mapWithKeys(fn(self $role) => [$role->value => $role->name])
            ->toArray();
    }
}
