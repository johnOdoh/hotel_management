<?php

namespace App\Filament\Resources\Bookings\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('#')
                    ->rowIndex()
                    ->sortable(),
                TextColumn::make('reference')
                    ->label('Booking Reference')
                    ->weight('semibold')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Guest Name')
                    ->weight('semibold')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('room.number')
                    ->label('Room number')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('room.category.name')
                    ->label('Room Type')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('check_in')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_out')
                    ->date()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('NGN')
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('booking_type')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Booked By')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('check_in')
                    ->label('Check-in Date')
                    ->form([
                        DatePicker::make('check_in_from')
                            ->label('Check-in From'),
                        DatePicker::make('check_in_until')
                            ->label('Check-in Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['check_in_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('check_in', '>=', $date),
                            )
                            ->when(
                                $data['check_in_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('check_in', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['check_in_from'] ?? null) {
                            $indicators[] = 'Check-in from ' . Carbon::parse($data['check_in_from'])->toFormattedDateString();
                        }

                        if ($data['check_in_until'] ?? null) {
                            $indicators[] = 'Check-in until ' . Carbon::parse($data['check_in_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),

                Filter::make('check_out')
                    ->label('Check-out Date')
                    ->form([
                        DatePicker::make('check_out_from')
                            ->label('Check-out From'),
                        DatePicker::make('check_out_until')
                            ->label('Check-out Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['check_out_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('check_out', '>=', $date),
                            )
                            ->when(
                                $data['check_out_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('check_out', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['check_out_from'] ?? null) {
                            $indicators[] = 'Check-out from ' . Carbon::parse($data['check_out_from'])->toFormattedDateString();
                        }

                        if ($data['check_out_until'] ?? null) {
                            $indicators[] = 'Check-out until ' . Carbon::parse($data['check_out_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn($record) => ! $record->is_completed),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
