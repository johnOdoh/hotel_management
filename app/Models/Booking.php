<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\BookingType;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

#[Unguarded]
class Booking extends Model
{
    use HasUlids;

    protected function casts(): array
    {
        return [
            'check_in' => 'datetime',
            'check_out' => 'datetime',
            'amount' => 'decimal:2',
            'number_of_guests' => 'integer',
            'is_completed' => 'boolean',
            'status' => BookingStatus::class,
            'booking_type' => BookingType::class,
        ];
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }
}
