<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kitchen extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'location',
        'floor',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

    public function kitchenOrders(): HasMany
    {
        return $this->hasMany(KitchenOrder::class);
    }

    public function activeOrders()
    {
        return $this->kitchenOrders()
            ->whereIn('status', ['pending', 'confirmed', 'preparing'])
            ->orderBy('order_time', 'asc');
    }
}
