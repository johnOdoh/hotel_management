<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
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
                    ->placeholder('Name')
                    ->required()
                    ->readOnlyOn('edit'),
                TextInput::make('email')
                    ->label('Email address')
                    ->placeholder('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->readOnlyOn('edit')
                    ->required(),
                Select::make('role')
                    ->label('Role')
                    ->required()
                    ->options(UserRole::class),
                Toggle::make('is_active')
                    ->required()
                    ->inline(false)
                    ->default(true),
            ]);
    }
}