<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ride;

class RidesController extends Controller
{
    /**
     * Display a listing of the current user's rides.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        // Query the rides of the current users
        $user = Auth::user();
        $userRidesAsDriver = $user->futureRidesAsDriver();
        $userRidesAsPassenger = $user->futureRidesAsPassenger();


        return view('home', [
            'futureRidesAsDriver' => $userRidesAsDriver,
            'futureRidesAsPassenger' => $userRidesAsPassenger
            ]);

    }

    /**
     * Display a listing of rides queried by a search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function queryRides(Request $request)
    {
        // Query the rides matching the search parameter
        $departure = $request->input('departure',"");
        $destination = $request->input('destination',"");
        $departureTime = $request->input('departureTime',"");

        $retrievedRides = Ride::
        where('departure','like','%' . $departure . '%')
            ->where('destination','like','%' . $destination . '%')
            ->where('departureTime','like',substr($departureTime,0,10) . '%')
            ->get();

        return view('searchResults', ['retrievedRides' => $retrievedRides]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ride = new Ride;
        $ride->departure = $request->departure;
        $ride->departureTime = $request->departureTime;
        $ride->destination = $request->destination;
        $ride->availableSeats = $request->availableSeats;
        $ride->price = $request->price;
        $ride->driverID = Auth::user()->getAuthIdentifier();
        $ride->save();

        return redirect()->route('home.index')->with('success', 'Ride has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ride = Ride::find($id);
        $ride->departure = $request->departure;
        $ride->destination = $request->destination;
        $ride->departureTime = $request->departureTime;
        $ride->availableSeats = $request->availableSeats;
        $ride->price = $request->price;
        $ride->save();
        return redirect()->route('home.index')
            ->with('success','Ride has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ride::destroy($id);
        return redirect('home')->with('success','Ride has been deleted successfully');;
    }


    /**
     * Add a user as passenger to a ride.
     *
     * @param int $rideID
     * @param int $userID
     * @return \Illuminate\Http\JsonResponse
     */
    public function joinRide(Request $request)
    {
        // TODO: Check if there are seats availble & if so, add (rideID, userID) to the rides_user_table

        $ride = Ride::find($request->input('rideID'));
        $joinSuccessful = false;

        // check if there are still seats available
        if ($ride->availableSeats > $ride->numberOfPassengers()) {
            $ride->passengers()->attach($request->input('userID'));
            $joinSuccessful = true;
        }

        return response()->json([
            'joinSuccessful' => $joinSuccessful,
        ]);
    }


    /**
     * Remove a user as passenger from a ride.
     *
     * @param int $rideID
     * @param int $userID
     * @return \Illuminate\Http\JsonResponse
     */
    public function unjoinRide(Request $request)
    {

        $ride = Ride::find($request->input('rideID'));
        $passenger = User::find($request->input('userID'));
        $unjoinSuccessful = false;

        // if passenger indeed joined the ride, delete the booking
        if ($ride->passengers->contains($passenger)) {
            $ride->passengers()->detach($request->input('userID'));
            $unjoinSuccessful = true;
        }

        //return response();
        return response()->json([
            'unjoinSuccessful' => $unjoinSuccessful,
        ]);

    }
}
