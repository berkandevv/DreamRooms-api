<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Define la conversión de tipos de los atributos
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Devuelve el rol del usuario
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Comprueba si el usuario tiene alguno de los roles indicados
    public function hasRole(string|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];

        return in_array($this->role?->name, $roles, true);
    }

    // Devuelve los hoteles que pertenecen al usuario
    public function ownedHotels(): HasMany
    {
        return $this->hasMany(Hotel::class, 'owner_user_id');
    }

    // Devuelve las reservas del usuario
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Devuelve las reseñas escritas por el usuario
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Devuelve los hoteles favoritos del usuario
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
