<?php

namespace App\Enums;

enum UserRole: string
{
    case OWNER = 'Owner';
    case MANAGER = 'Manager';
    case RECEPTIONIST = 'Receptionist';
}
