<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'payment_number',
        'invoice_id',
        'reservation_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'notes',
        'payment_date',
        'processed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_number)) {
                $payment->payment_number = 'PAY-' . strtoupper(Str::random(10));
            }
        });
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
