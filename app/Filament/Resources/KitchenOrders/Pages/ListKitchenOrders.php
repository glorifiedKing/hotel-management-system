<?php

namespace App\Filament\Resources\KitchenOrders\Pages;

use App\Filament\Resources\KitchenOrders\KitchenOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKitchenOrders extends ListRecords
{
    protected static string $resource = KitchenOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
