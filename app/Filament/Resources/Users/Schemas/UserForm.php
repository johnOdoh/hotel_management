<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->readOnly(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->readOnly()
                    ->required(),
                TextInput::make('job_title')
                    ->label('Job Title')
                    ->required(),
                Select::make('department')
                    ->label('Department')
                    ->required()
                    ->options(Department::toOptions()),
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
