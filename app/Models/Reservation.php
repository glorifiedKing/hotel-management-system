<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_number',
        'guest_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'number_of_rooms',
        'status',
        'total_amount',
        'deposit_amount',
        'booking_source',
        'special_requests',
        'checked_in_at',
        'checked_out_at',
        'created_by',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            if (empty($reservation->reservation_number)) {
                $reservation->reservation_number = 'RES-' . strtoupper(Str::random(10));
            }
        });
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'reservation_rooms')
            ->withPivot('room_rate', 'number_of_guests')
            ->withTimestamps();
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function posOrders(): HasMany
    {
        return $this->hasMany(PosOrder::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
