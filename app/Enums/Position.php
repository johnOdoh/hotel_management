<?php

namespace App\Enums;

enum Position: string
{
    case Receptionist = 'Receptionist';
    case Security = 'Security';
    case Cook = 'Cook';
    case Cleaner = 'Cleaner';
    case Potter = 'Potter';
}
