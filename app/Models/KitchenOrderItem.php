<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KitchenOrderItem extends Model
{
    protected $fillable = [
        'kitchen_order_id',
        'service_id',
        'quantity',
        'status',
        'special_instructions',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function kitchenOrder(): BelongsTo
    {
        return $this->belongsTo(KitchenOrder::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
