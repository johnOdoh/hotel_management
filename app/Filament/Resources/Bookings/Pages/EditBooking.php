<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    #[Override]
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['room_category'] = $this->record->room->room_category_id;
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
