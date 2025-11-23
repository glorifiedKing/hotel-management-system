<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'location',
        'floor',
        'opening_time',
        'closing_time',
        'seating_capacity',
        'kitchen_id',
        'is_active',
        'accepts_reservations',
        'operating_days',
    ];

    protected $casts = [
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
        'is_active' => 'boolean',
        'accepts_reservations' => 'boolean',
        'operating_days' => 'array',
    ];

    public function kitchen(): BelongsTo
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function tables(): HasMany
    {
        return $this->hasMany(RestaurantTable::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function kitchenOrders(): HasMany
    {
        return $this->hasMany(KitchenOrder::class);
    }

    public function availableTables()
    {
        return $this->tables()->where('status', 'available')->where('is_active', true);
    }

    public function isOpen()
    {
        $now = now();
        $currentDay = strtolower($now->format('l'));

        // Check if restaurant operates today
        if ($this->operating_days && !in_array($currentDay, $this->operating_days)) {
            return false;
        }

        // Check if within operating hours
        if ($this->opening_time && $this->closing_time) {
            $currentTime = $now->format('H:i:s');
            return $currentTime >= $this->opening_time && $currentTime <= $this->closing_time;
        }

        return true;
    }
}
