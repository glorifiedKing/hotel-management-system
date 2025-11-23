<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type_id',
        'floor',
        'status',
        'notes',
        'is_smoking',
        'is_accessible',
    ];

    protected $casts = [
        'is_smoking' => 'boolean',
        'is_accessible' => 'boolean',
    ];

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservation_rooms')
            ->withPivot('room_rate', 'number_of_guests')
            ->withTimestamps();
    }

    public function housekeepingTasks(): HasMany
    {
        return $this->hasMany(HousekeepingTask::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}
