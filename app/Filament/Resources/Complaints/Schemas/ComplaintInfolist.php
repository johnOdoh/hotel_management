<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Submitted By')
                    ->placeholder('-'),
                TextEntry::make('subject'),
                TextEntry::make('body')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('priority')
                    ->badge(),
                ImageEntry::make('attachment')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Submitted On')
                    ->dateTime()
                    ->placeholder('-')
            ]);
    }
}
