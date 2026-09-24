<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->description('Basic details about the staff member')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('Email address'),
                        TextEntry::make('phone')
                            ->label('Phone Number'),
                        TextEntry::make('address'),
                        TextEntry::make('state'),
                        TextEntry::make('lga')
                            ->label('LGA'),
                        TextEntry::make('hometown'),
                        TextEntry::make('gender')
                            ->color('primary')
                            ->badge(),
                        TextEntry::make('marital_status')
                            ->color('primary')
                            ->badge(),
                        TextEntry::make('emergency_contact_details')
                            ->label('Emergency Contact Name')
                            ->formatStateUsing(fn($state) => $state['name'] ?? 'N/A')
                            ->placeholder('N/A'),
                        TextEntry::make('emergency_contact_details')
                            ->label('Emergency Contact Phone Number')
                            ->formatStateUsing(fn($state) => $state['phone'] ?? 'N/A')
                            ->placeholder('N/A'),
                        TextEntry::make('emergency_contact_details')
                            ->label('Emergency Contact Address')
                            ->formatStateUsing(fn($state) => $state['address'] ?? 'N/A')
                            ->placeholder('N/A'),
                        TextEntry::make('emergency_contact_details')
                            ->label('Relationship to Emergency Contact')
                            ->formatStateUsing(fn($state) => $state['relationship'] ?? 'N/A')
                            ->placeholder('N/A')
                            ->color('warning')
                            ->badge(),
                    ]),
                Section::make('Employment Information')
                    ->description('Details about the staff member\'s employment')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('position'),
                        TextEntry::make('employment_status')
                            ->badge(),
                        TextEntry::make('employment_date')
                            ->date(),
                        TextEntry::make('salary')
                            ->numeric()
                            ->money('NGN')
                            ->color('success')
                            ->badge(),
                        RepeatableEntry::make('account_details')
                            ->schema([
                                TextEntry::make('bank_name'),
                                TextEntry::make('account_name'),
                                TextEntry::make('account_number')
                            ])
                            ->placeholder('N/A')
                            ->columns([
                                'default' => 3,
                                'md' => 2,
                                'lg' => 3,
                            ]),
                        ImageEntry::make('cv')
                            ->label('CV')
                            ->disk('public')
                            ->imageHeight(80)
                            ->square()
                            ->url(fn($record) => Storage::disk('public')->url($record->id_document))
                            ->openUrlInNewTab(),
                        ImageEntry::make('id_document')
                            ->label('ID')
                            ->disk('public')
                            ->imageHeight(80)
                            ->square()
                            ->url(fn($record) => Storage::disk('public')->url($record->id_document))
                            ->openUrlInNewTab(),
                    ]),
            ]);
    }
}