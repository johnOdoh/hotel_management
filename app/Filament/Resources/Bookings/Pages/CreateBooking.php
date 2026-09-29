<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Actions\GenerateBookingReference;
use App\Enums\BookingStatus;
use App\Enums\BookingType;
use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['booked_by'] = auth()->user()->id;
        $data['booking_type'] = BookingType::Walk_In;
        $data['status'] = BookingStatus::CheckedIn;
        $data['reference'] = app(GenerateBookingReference::class)($data['name']);

        return $data;
    }
}
