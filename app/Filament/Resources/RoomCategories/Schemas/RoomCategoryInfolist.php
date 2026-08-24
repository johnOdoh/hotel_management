<?php

namespace App\Filament\Resources\RoomCategories\Schemas;

use App\Models\Feature;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoomCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('amount')
                    ->label('Amount(₦)')
                    ->numeric(),
                TextEntry::make('description')
                    ->prose()
                    ->columnSpanFull(),
                TextEntry::make('capacity')
                    ->numeric(),
                TextEntry::make('size')
                    ->label('Size(sqft)')
                    ->numeric(),
                ImageEntry::make('images')
                    ->disk('public')
                    ->imageHeight(80)
                    ->imageWidth(80),
                TextEntry::make('features')
                    ->label('Features')
                    ->state(function ($record) {
                        return Feature::whereIn('id', $record->features)->pluck('name');
                    })
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}