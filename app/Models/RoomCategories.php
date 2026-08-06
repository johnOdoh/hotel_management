<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class RoomCategories extends Model
{
    use HasFactory, HasUlids;

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'features' => 'array',
            'amount' => 'decimal:2',
            'capacity' => 'integer',
            'size' => 'float',
        ];
    }
}
