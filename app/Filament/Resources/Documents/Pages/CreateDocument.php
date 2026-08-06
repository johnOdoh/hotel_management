<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sender_id'] = request()->user()->id;
        $data['recipient_id'] = User::where('email', $data['recipient'])->first('id')->id;
        unset($data['recipient']);
        return $data;
    }
}
