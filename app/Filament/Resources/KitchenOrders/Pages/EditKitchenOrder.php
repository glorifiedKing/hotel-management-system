<?php

namespace App\Filament\Resources\KitchenOrders\Pages;

use App\Filament\Resources\KitchenOrders\KitchenOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKitchenOrder extends EditRecord
{
    protected static string $resource = KitchenOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
