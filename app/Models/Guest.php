<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'id_type',
        'id_number',
        'date_of_birth',
        'address',
        'city',
        'state',
        'postal_code',
        'guest_type',
        'loyalty_points',
        'preferences',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'preferences' => 'array',
        'loyalty_points' => 'integer',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function posOrders(): HasMany
    {
        return $this->hasMany(PosOrder::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
