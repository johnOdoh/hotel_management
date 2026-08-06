<?php

namespace App\Models;

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
            'check_in' => 'date',
            'check_out' => 'date',
            'amount' => 'decimal:2',
            'number_of_guests' => 'integer',
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
