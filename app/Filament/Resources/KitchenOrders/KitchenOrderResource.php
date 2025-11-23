<?php

namespace App\Filament\Resources\KitchenOrders;

use App\Filament\Resources\KitchenOrders\Pages\CreateKitchenOrder;
use App\Filament\Resources\KitchenOrders\Pages\EditKitchenOrder;
use App\Filament\Resources\KitchenOrders\Pages\ListKitchenOrders;
use App\Filament\Resources\KitchenOrders\Schemas\KitchenOrderForm;
use App\Filament\Resources\KitchenOrders\Tables\KitchenOrdersTable;
use App\Models\KitchenOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KitchenOrderResource extends Resource
{
    protected static ?string $model = KitchenOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return KitchenOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KitchenOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKitchenOrders::route('/'),
            'create' => CreateKitchenOrder::route('/create'),
            'edit' => EditKitchenOrder::route('/{record}/edit'),
        ];
    }
}
