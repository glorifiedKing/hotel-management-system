<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class KitchenOrder extends Model
{
    protected $fillable = [
        'order_number',
        'restaurant_id',
        'kitchen_id',
        'restaurant_table_id',
        'pos_order_id',
        'guest_id',
        'order_type',
        'status',
        'number_of_guests',
        'special_instructions',
        'order_time',
        'confirmed_at',
        'prepared_at',
        'served_at',
        'waiter_id',
        'chef_id',
    ];

    protected $casts = [
        'order_time' => 'datetime',
        'confirmed_at' => 'datetime',
        'prepared_at' => 'datetime',
        'served_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'KO-' . strtoupper(Str::random(10));
            }
        });
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function kitchen(): BelongsTo
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function restaurantTable(): BelongsTo
    {
        return $this->belongsTo(RestaurantTable::class);
    }

    public function posOrder(): BelongsTo
    {
        return $this->belongsTo(PosOrder::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(KitchenOrderItem::class);
    }

    public function waiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function chef(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chef_id');
    }
}
