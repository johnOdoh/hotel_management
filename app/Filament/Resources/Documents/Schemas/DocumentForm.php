<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Enums\DocumentType;
use App\Enums\Priority;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('recipient')
                    ->label('Recipient Email')
                    ->email()
                    ->exists(table: 'users', column: 'email')
                    ->required(),
                Textarea::make('description'),
                FileUpload::make('file')
                    ->label('Document')
                    ->required()
                    ->disk('public')
                    ->directory('forms/documents')
                    ->visibility('public')
                    ->moveFiles()
                    ->maxSize(1024)
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
                Select::make('type')
                    ->options(DocumentType::toOptions())
                    ->required()
                    ->live(),
                TextInput::make('amount')
                    // ->required()
                    ->numeric()
                    ->prefix('₦')
                    ->visible(fn($get) => in_array($get('type'), [DocumentType::Invoice->value, DocumentType::Expense_Claim->value, DocumentType::Reimbursement->value, DocumentType::Purchase_Order->value])),
                Select::make('priority')
                    ->options(Priority::toOptions())
                    ->required()
            ]);
    }
}
