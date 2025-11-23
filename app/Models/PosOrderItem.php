<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosOrderItem extends Model
{
    protected $fillable = [
        'pos_order_id',
        'service_id',
        'quantity',
        'unit_price',
        'total_price',
        'special_instructions',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function posOrder(): BelongsTo
    {
        return $this->belongsTo(PosOrder::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
