<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('profile.job_title')
                    ->label('Job Title')
                    ->placeholder('-'),
                TextEntry::make('profile.department')
                    ->label('Department')
                    ->placeholder('-'),
                TextEntry::make('profile.phone')
                    ->label('Phone Number')
                    ->placeholder('-'),
                ImageEntry::make('profile.image')
                    ->disk('public')
                    ->placeholder('-'),
                ImageEntry::make('profile.e_signature')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
