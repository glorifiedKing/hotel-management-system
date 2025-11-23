<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'employee_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'position',
        'hourly_rate',
        'hire_date',
        'termination_date',
        'employment_status',
        'address',
        'emergency_contact',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'termination_date' => 'date',
        'hourly_rate' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
