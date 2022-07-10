<?php

namespace Database\Factories;

use App\Models\Ride;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RideFactory extends Factory
{
    protected $model = \App\Models\Ride::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'departure' => $this->faker->address,
            'departureTime' => $this->faker->dateTimeBetween('+1 week', '+2 month'),
            'destination' => $this->faker->address,
            'availableSeats' => 4,
            'price' => 10.00,
            'driverID' => $this->faker->randomNumber(1)
        ];
    }
}
