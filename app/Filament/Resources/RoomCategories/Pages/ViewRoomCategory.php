<?php

namespace App\Filament\Resources\RoomCategories\Pages;

use App\Filament\Resources\RoomCategories\RoomCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRoomCategory extends ViewRecord
{
    protected static string $resource = RoomCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
