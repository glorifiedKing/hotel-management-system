<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'description',
        'unit_of_measurement',
        'current_stock',
        'minimum_stock',
        'maximum_stock',
        'reorder_point',
        'cost_per_unit',
        'storage_location',
        'expiry_date',
        'is_perishable',
        'is_active',
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
        'maximum_stock' => 'decimal:2',
        'reorder_point' => 'decimal:2',
        'cost_per_unit' => 'decimal:2',
        'expiry_date' => 'date',
        'is_perishable' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function purchaseOrderItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->reorder_point;
    }

    public function isOutOfStock(): bool
    {
        return $this->current_stock <= 0;
    }
}
