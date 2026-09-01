<?php

namespace App\Filament\Resources\RoomCategories\RelationManagers;

use App\Enums\RoomStatus;
use App\Models\Room;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\ValidationException;

class RoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'rooms';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        // Check if we are editing an existing single Room record
        $isEditing = $schema->getRecord() !== null;

        if ($isEditing) {
            return $schema->schema([
                TextInput::make('number')
                    ->label('Room number')
                    ->placeholder('Room number')
                    ->required()
                    ->minValue(1)
                    ->integer()
                    ->numeric()
                    ->unique(ignoreRecord: true),
                Select::make('status')
                    ->required()
                    ->options(RoomStatus::class),
            ]);
        }

        return $schema
            ->components([
                Repeater::make('rooms')
                    ->schema([
                        TextInput::make('number')
                            ->label('Room number')
                            ->placeholder('Room number')
                            ->required()
                            ->minValue(1)
                            ->integer()
                            ->numeric(),
                    ])
                    ->reorderable(false)
                    ->columnSpanFull()
                    ->grid(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
            ->columns([
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
            ])
            ->inverseRelationship('category')
            ->defaultSort('number')
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Rooms')
                    ->using(function (RelationManager $livewire, array $data) {
                        $category = $livewire->getOwnerRecord();
                        $roomEntries = collect($data['rooms'] ?? []);

                        // 1. Check for duplicates within the current input batch
                        $numbers = $roomEntries->pluck('number');
                        if ($numbers->duplicates()->isNotEmpty()) {
                            throw ValidationException::withMessages([
                                'rooms.*.number' => 'Duplicate room numbers in your input batch.',
                            ]);
                        }

                        // 2. Check for duplicates already belonging to this parent record
                        $existing = Room::whereIn('number', $numbers)->exists();
                        if ($existing) {
                            throw ValidationException::withMessages([
                                'rooms.*.number' => 'Some room number already exist',
                            ]);
                        }

                        // 3. Create and associate each room record via the relationship
                        $createdRooms = $roomEntries->map(function ($roomData) use ($category) {
                            return $category->rooms()->create([
                                'number' => $roomData['number'],
                                'status' => RoomStatus::Open,
                            ]);
                        });

                        // Return the last created record to satisfy Filament's return requirement
                        return $createdRooms->last();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
