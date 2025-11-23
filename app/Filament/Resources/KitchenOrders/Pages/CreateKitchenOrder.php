<?php

namespace App\Filament\Resources\KitchenOrders\Pages;

use App\Filament\Resources\KitchenOrders\KitchenOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKitchenOrder extends CreateRecord
{
    protected static string $resource = KitchenOrderResource::class;
}
