<?php

namespace App\Filament\Resources\RoomCategories\Schemas;

use App\Models\Feature;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Enums\GridDirection;

class RoomCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->placeholder('Name')
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('amount')
                    ->placeholder('Amount')
                    ->prefix('₦')
                    ->minValue(1)
                    ->step(0.01)
                    ->required()
                    ->numeric(),
                FileUpload::make('images')
                    ->image()
                    ->disk('public')
                    ->directory('rooms')
                    ->multiple()
                    ->maxFiles(5)
                    ->imagePreviewHeight(100)
                    ->panelLayout('grid')
                    ->maxSize(10240),
                RichEditor::make('description')
                    ->required()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike'],
                        [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])->textualButtons()],
                        [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                        ['bulletList', 'orderedList'],
                        ['undo', 'redo'],
                    ]),
                TextInput::make('capacity')
                    ->placeholder('Number of guests')
                    ->required()
                    ->numeric(),
                TextInput::make('size')
                    ->placeholder('Size in sqft')
                    ->required()
                    ->step(0.1)
                    ->minValue(1)
                    ->numeric(),
                CheckboxList::make('features')
                    ->options(Feature::pluck('name', 'id'))
                    ->required()
                    ->columnSpanFull()
                    ->columns([
                        'sm' => 2,
                        'md' => 3,
                        'lg' => 5,
                        'xl' => 5
                    ])
                    ->searchable()
                    ->gridDirection(GridDirection::Row),
            ]);
    }
}
