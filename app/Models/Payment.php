<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'provider',
        'amount',
        'currency',
        'status',
        'transaction_reference',
        'paid_at',
        'metadata',
    ];

    // Define la conversión de tipos de los atributos
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    // Devuelve la reserva asociada al pago
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
