<?php

namespace App\Filament\Resources\Complaints\Schemas;

use App\Enums\Priority;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subject')
                    ->required(),
                Select::make('priority')
                    ->options(Priority::toOptions())
                    ->default('Low')
                    ->required(),
                Textarea::make('body')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('attachment')
                    ->label('Attachment (optional)')
                    ->disk('public')
                    ->directory('complaints/attachments')
                    ->visibility('public')
                    ->moveFiles()
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/*']),
            ]);
    }
}
