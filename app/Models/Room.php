<?php

namespace App\Models;

use App\Enums\RoomStatus;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RoomCategories;

#[Unguarded]
class Room extends Model
{
    use HasFactory, HasUlids;
    
    protected function casts(): array
    {
        return [
            'status' => RoomStatus::class,
        ];
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(RoomCategories::class);
    }
}
