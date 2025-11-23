<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PosOrder extends Model
{
    protected $fillable = [
        'order_number',
        'reservation_id',
        'guest_id',
        'order_type',
        'subtotal',
        'tax_amount',
        'total_amount',
        'status',
        'charge_to_room',
        'served_by',
        'order_time',
        'delivered_at',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'charge_to_room' => 'boolean',
        'order_time' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(10));
            }
        });
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PosOrderItem::class);
    }

    public function servedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'served_by');
    }
}
