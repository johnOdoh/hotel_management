<?php

namespace App\Filament\Resources\RoomCategories;

use App\Filament\Resources\RoomCategories\Pages\CreateRoomCategory;
use App\Filament\Resources\RoomCategories\Pages\EditRoomCategory;
use App\Filament\Resources\RoomCategories\Pages\ListRoomCategories;
use App\Filament\Resources\RoomCategories\Pages\ViewRoomCategory;
use App\Filament\Resources\RoomCategories\RelationManagers\RoomsRelationManager;
use App\Filament\Resources\RoomCategories\Schemas\RoomCategoryForm;
use App\Filament\Resources\RoomCategories\Schemas\RoomCategoryInfolist;
use App\Filament\Resources\RoomCategories\Tables\RoomCategoriesTable;
use App\Models\RoomCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoomCategoryResource extends Resource
{
    protected static ?string $model = RoomCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RoomCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RoomCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoomCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RoomsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoomCategories::route('/'),
            'create' => CreateRoomCategory::route('/create'),
            'view' => ViewRoomCategory::route('/{record}'),
            'edit' => EditRoomCategory::route('/{record}/edit'),
        ];
    }
}