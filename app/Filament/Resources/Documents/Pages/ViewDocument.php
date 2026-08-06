<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Enums\DocumentStatus;
use App\Filament\Resources\Documents\DocumentResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            Action::make('approve')
                ->icon('heroicon-o-check-circle')
                ->outlined()
                ->labeledFrom('md')
                ->color('success')
                ->modalHeading('Approve Document')
                ->successNotificationTitle('Document Approved Successfully')
                ->hidden(fn($record) => $record->status !== DocumentStatus::Pending)
                ->schema([
                    FileUpload::make('approved_file')
                        ->label('Upload Approved Document')
                        ->required()
                        ->disk('public')
                        ->directory('forms/documents/approved')
                        ->visibility('public')
                        ->moveFiles()
                        ->maxSize(1024)
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
                    TextInput::make('additional_note')
                        ->label('Additional Note')
                        ->placeholder('Optional remarks for approval'),
                ])
                ->action(function ($record, $data) {
                    $record->status = DocumentStatus::Approved;
                    $record->approved_file = $data['approved_file'];
                    $record->save();
                    // $this->redirect(ListDocuments::getUrl());
                }),
            Action::make('reject')
                ->icon('heroicon-o-x-circle')
                ->outlined()
                ->labeledFrom('md')
                ->color('danger')
                ->modalHeading('Reject Document')
                ->successNotificationTitle('Document Rejected Successfully')
                ->hidden(fn($record) => $record->status !== DocumentStatus::Pending)
                ->schema([
                    TextInput::make('additional_note')
                        ->label('Additional Note')
                        ->placeholder('Optional remarks for refusal')
                ])
                ->action(function ($record) {
                    $record->status = DocumentStatus::Rejected;
                    $record->save();
                    // $this->redirect(ListDocuments::getUrl());
                }),
        ];
    }
}