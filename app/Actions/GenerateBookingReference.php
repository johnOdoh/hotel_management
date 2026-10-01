<?php

namespace App\Actions;

use App\Models\Booking;
use Illuminate\Support\Str;

class GenerateBookingReference
{
    public function __invoke(string $name): string
    {
        $prefix = Str::of($name)
            ->explode(' ')
            ->take(2)
            ->map(fn($w) => Str::substr($w, 0, 1))
            ->implode('');
        do {
            $reference = strtoupper($prefix . Str::random(6));
        } while (Booking::where('reference', $reference)->exists());

        return $reference;
    }
}
