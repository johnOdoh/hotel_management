<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Actions\CheckRoomAvailability;
use App\Models\RoomCategory;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class BookingForm
{
    protected static function checkAvailability(): \Closure
    {
        return function ($get, $set, $record) {
            if (empty($get('room_category')) || empty($get('check_in')) || empty($get('check_out'))) {
                return [];
            }
            $check_in = Carbon::parse($get('check_in'));
            $check_out = Carbon::parse($get('check_out'));
            if ($check_in >= $check_out) {
                Notification::make()
                    ->title('Invalid Date Range')
                    ->body('Check-out date must be after check-in date.')
                    ->danger()
                    ->send();
                // Reset dependent fields
                $set('days', null);
                $set('amount_per_day', null);
                $set('amount', null);
                return [];
            }
            $rooms = app(CheckRoomAvailability::class)->handle($get('room_category'), $get('check_in'), $get('check_out'));
            if (count($rooms) < 1) {
                Notification::make()
                    ->title('No Rooms Available')
                    ->body('All rooms are fully booked from ' . $check_in->format('M d') . ' to ' . $check_out->format('M d, Y') . '.')
                    ->danger()
                    ->send();
                return [];
            }
            $amount = RoomCategory::findOrFail($get('room_category'))->amount;
            $days = $check_in->diffInDays($check_out);
            $set('days', $days);
            $set('amount_per_day', number_format((float) $amount, 2));
            $set('amount', number_format($amount * $days, 2, '.', ''));
            $rooms = $rooms->pluck('number', 'id')->toArray();
            if ($record && $record->room->room_category_id == $get('room_category')) {
                $rooms[$record->room_id] = $record->room->number;
            }
            return $rooms;;
        };
    }
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'default' => 1,
                'lg' => 2
            ])
            ->components([
                Fieldset::make('Room Information')
                    ->schema([
                        Select::make('room_category')
                            ->required()
                            ->options(RoomCategory::pluck('name', 'id'))
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.room_category" />')))
                            ->live(),
                        DatePicker::make('check_in')
                            ->required()
                            ->minDate(now())
                            ->maxDate(fn($get) => $get('check_out') ?? now()->addYear())
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.check_in" />')))
                            ->live(),
                        DatePicker::make('check_out')
                            ->required()
                            ->minDate(fn($get) => $get('check_in') ?? now())
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.check_out" />')))
                            ->live(),
                        Select::make('room_id')
                            ->label('Room Number')
                            ->options(self::checkAvailability())
                            ->reactive()
                            ->required(),
                        Grid::make([
                            'default' => 1,
                            'md' => 3
                        ])
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('days')
                                    ->readOnly()
                                    ->required(),
                                TextInput::make('amount_per_day')
                                    ->required()
                                    ->readOnly()
                                    ->prefix('₦'),
                                TextInput::make('amount')
                                    ->label('Total Amount')
                                    ->required()
                                    ->readOnly()
                                    ->prefix('₦'),
                            ])
                    ]),
                Fieldset::make('Guest Information')
                    ->schema([
                        TextInput::make('name')
                            ->placeholder('Full Name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->placeholder('Email address')
                            ->required()
                            ->email(),
                        TextInput::make('phone')
                            ->label('Phone number')
                            ->placeholder('Phone Number')
                            ->tel()
                            ->required(),
                        TextInput::make('number_of_guests')
                            ->placeholder('Number of Guests')
                            ->required()
                            ->integer()
                            ->minValue(1)
                            ->numeric(),

                    ])
            ]);
    }
}
