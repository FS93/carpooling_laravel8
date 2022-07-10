<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return the rides in which the user acts as driver.
     */
    public function ridesAsDriver() {
        return $this->hasMany(Ride::class, 'driverID');
    }

    /**
     * Return the upcoming rides in which the user acts as driver.
     */
    public function futureRidesAsDriver() {
        return $this->ridesAsDriver()->where('departureTime','>=',now())->get();
    }

    /**
     * Return the rides in which the user is a passenger.
     */

    public function ridesAsPassenger() {
        return $this->belongsToMany(Ride::class, 'rides_users_pivot', 'passengerID', 'rideID')->as('booking')->withTimestamps();
    }

    /**
     * Return the upcoming rides in which the user is a passenger.
     */

    public function futureRidesAsPassenger() {
        return $this->ridesAsPassenger()->where('departureTime', '>=', now())->get();
    }


}
