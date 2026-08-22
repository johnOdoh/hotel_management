<?php

namespace App\Actions;

use App\Models\Room;
use Carbon\Carbon;

class CheckRoomAvailability
{
    public function handle(string $category_id, string $checkIn, string $checkOut): bool
    {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);

        // Find rooms in this category that are open and not booked during the selected dates
        $room_count = Room::where('room_category_id', $category_id)
            ->whereDoesntHave('reservations', function ($query) use ($checkInDate, $checkOutDate) {
                $query->where('is_completed', false)
                    ->where(function ($query) use ($checkInDate, $checkOutDate) {
                        $query->where('check_in', '<', $checkOutDate)
                                ->where('check_out', '>', $checkInDate);
                    });
            })
            ->count();

        return $room_count;
    }
}
