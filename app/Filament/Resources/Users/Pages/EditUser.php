<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['job_title'] = $this->record->profile?->job_title;
        $data['department'] = $this->record->profile?->department;
        $data['phone'] = $this->record->profile?->phone;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->record->profile()->update(
            [
                'job_title' => $data['job_title'],
                'department' => $data['department'],
                'phone' => $data['phone'],
            ]
        );
        unset($data['job_title'], $data['department'], $data['phone']);

        return $data;
    }
}
