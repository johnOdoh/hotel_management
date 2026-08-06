<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('sender.name')
                    ->label('Sender'),
                TextEntry::make('recipient.name')
                    ->label('Recipient'),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-'),
                TextEntry::make('file')
                    ->label('Document')
                    ->formatStateUsing(fn($state) => $state ? 'View Document' : 'No file')
                    ->url(fn($state) => $state ? Storage::url($state) : 'N/A', true)
                    ->color('primary'),
                TextEntry::make('approved_file')
                    ->label('Approved Document')
                    ->formatStateUsing(fn($state) => $state ? 'View Document' : 'No file')
                    ->url(fn($state) => $state ? Storage::url($state) : 'N/A', true)
                    ->visible(fn($record) => $record->approved_file !== null)
                    ->color('success'),
                TextEntry::make('amount')
                    ->label('Amount (₦)')
                    ->numeric()
                    ->visible(fn($record) => $record->amount !== null)
                    ->placeholder('-'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('priority')
                    ->badge(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
