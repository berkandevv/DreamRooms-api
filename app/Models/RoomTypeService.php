<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoomTypeService extends Pivot
{
    public $incrementing = true;

    protected $table = 'room_type_services';

    protected $fillable = [
        'room_type_id',
        'service_id',
    ];

    // Devuelve el tipo de habitación asociado al servicio
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    // Devuelve el servicio asociado al tipo de habitación
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
