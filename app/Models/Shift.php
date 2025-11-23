<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    protected $fillable = [
        'employee_id',
        'shift_date',
        'start_time',
        'end_time',
        'actual_start_time',
        'actual_end_time',
        'shift_type',
        'status',
        'notes',
    ];

    protected $casts = [
        'shift_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
