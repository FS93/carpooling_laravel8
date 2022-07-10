<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'rides';

    protected $fillable = [
      'departure',
        'destination',
        'departureTime',
        'availableSeats',
        'price'
    ];

    /**
     * Get the driver associated with the ride.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driverID');
    }

    /**
     * Get the passengers associated with a ride.
     */
    public function passengers()
    {
        return $this->belongsToMany(User::class, 'rides_users_pivot','rideID', 'passengerID')->as('booking')->withTimestamps();
    }

    /**
     * Return the number of bookings on a ride.
     */

    public function numberOfPassengers() {
        return $this->passengers()->count();
    }
}

