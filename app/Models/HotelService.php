<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HotelService extends Pivot
{
    public $incrementing = true;

    protected $table = 'hotel_services';

    protected $fillable = [
        'hotel_id',
        'service_id',
    ];

    // Devuelve el hotel asociado al servicio
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    // Devuelve el servicio asociado al hotel
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
