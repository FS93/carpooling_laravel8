<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AvailableRides {
    public function getBy ($departure, $destination, $departureTime) {

        //return Ride::all()->where('departure',$departure);
        return DB::table('rides')
            ->where('departure','like','%' . $departure . '%')
            ->where('destination','like','%' . $destination . '%')
            ->where('departureTime','like',substr($departureTime,0,10) . '%')
            ->get();

    }
}
