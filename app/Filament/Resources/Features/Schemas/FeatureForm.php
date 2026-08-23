<?php

namespace App\Filament\Resources\Features\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->placeholder('Name')
                    ->required(),
                Select::make('icon')
                    ->required()
                    ->options(Heroicon::class)
                    ->native(false)
                    ->searchable(),
            ]);
    }
}
