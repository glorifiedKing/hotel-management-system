<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'room_id',
        'reported_by',
        'assigned_to',
        'title',
        'description',
        'category',
        'priority',
        'status',
        'reported_at',
        'scheduled_at',
        'completed_at',
        'resolution_notes',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
