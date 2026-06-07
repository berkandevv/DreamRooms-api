<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hotel_id',
    ];

    // Devuelve el usuario propietario del favorito
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Devuelve el hotel marcado como favorito
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
