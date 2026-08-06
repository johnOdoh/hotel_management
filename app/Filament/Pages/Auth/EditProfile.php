<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        if (!request()->user()->profile()->exists()) {
            $page = [
                TextInput::make('job_title')
                    ->label('Job Title')
                    ->required(),
                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required(),
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('profile/images')
                    ->imagePreviewHeight(100)
                    ->maxSize(2048)
                    ->required(),
                FileUpload::make('e_signature')
                    ->label('E-Signature')
                    ->image()
                    ->disk('public')
                    ->directory('profile/signatures')
                    ->imagePreviewHeight(100)
                    ->maxSize(2048),
            ];
        } else {
            $page = [
                $this->getNameFormComponent()->disabled(),
                $this->getEmailFormComponent()->disabled(),
                TextInput::make('job_title')
                    ->label('Job Title')
                    ->required(),
                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required(),
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('profile/images')
                    ->imagePreviewHeight(100)
                    ->maxSize(2048)
                    ->required(),
                FileUpload::make('e_signature')
                    ->label('E-Signature')
                    ->image()
                    ->disk('public')
                    ->directory('profile/signatures')
                    ->imagePreviewHeight(100)
                    ->maxSize(2048),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ];
        }
        return $schema
            ->components($page);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (request()->user()->profile()->exists()) {
            $data['job_title'] = request()->user()->profile->job_title;
            $data['phone'] = request()->user()->profile->phone;
            $data['image'] = request()->user()->profile->image;
            $data['e_signature'] = request()->user()->profile->e_signature;
        }
        return $data;
    }

    public function save(): void
    {
        $exists = request()->user()->profile()->exists();
        request()->user()->profile()->updateOrCreate(
            ['user_id' => request()->user()->id],
            [
                'job_title' => $this->form->getState()['job_title'],
                'phone' => $this->form->getState()['phone'],
                'image' => $this->form->getState()['image'],
                'e_signature' => $this->form->getState()['e_signature'],
            ],
        );
        if (!$exists) {
            $this->getSavedNotification()?->send();
            $this->redirect(request()->header('Referer'));
        } else parent::save();
    }
}
