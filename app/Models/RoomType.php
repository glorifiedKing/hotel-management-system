<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'base_price',
        'max_occupancy',
        'default_occupancy',
        'features',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities');
    }
}
