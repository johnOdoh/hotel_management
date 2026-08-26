<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->rowIndex()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('room.number')
                    ->label('Room number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('room.category.name')
                    ->label('Room Type')
                    ->sortable(),
                TextColumn::make('check_in')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_out')
                    ->date()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount (₦)')
                    ->numeric(),
                TextColumn::make('booking_type')
                    ->badge(),
                TextColumn::make('is_completed')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Completed' : 'Ongoing')
                    ->badge(fn($state) => $state ? 'success' : 'warning')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Booked By')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
