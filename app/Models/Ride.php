<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

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
        return $this->hasOne(User::class, 'driverID');
    }
}
