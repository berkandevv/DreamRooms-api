<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'image_url',
        'alt_text',
        'is_cover',
        'sort_order',
    ];

    // Define la conversión de tipos de los atributos
    protected function casts(): array
    {
        return [
            'is_cover' => 'boolean',
        ];
    }

    // Devuelve el hotel al que pertenece la imagen
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
