<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'category',
        'price',
        'is_available',
        'is_taxable',
        'track_inventory',
        'recipe',
        'preparation_time',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_taxable' => 'boolean',
        'track_inventory' => 'boolean',
        'recipe' => 'array',
        'preparation_time' => 'decimal:2',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function posOrderItems(): HasMany
    {
        return $this->hasMany(PosOrderItem::class);
    }
}
