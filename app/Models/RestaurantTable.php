<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantTable extends Model
{
    protected $fillable = [
        'restaurant_id',
        'table_number',
        'location',
        'capacity',
        'status',
        'section',
        'floor',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function kitchenOrders(): HasMany
    {
        return $this->hasMany(KitchenOrder::class);
    }

    public function currentOrder()
    {
        return $this->hasOne(KitchenOrder::class)
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->latest();
    }
}
