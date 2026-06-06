<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'user_id',
        'booking_id',
        'rating',
        'comment',
        'image_url',
        'status',
    ];

    // Devuelve el hotel de la reseña
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    // Devuelve el cliente que escribió la reseña
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Devuelve la reserva de la reseña
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
