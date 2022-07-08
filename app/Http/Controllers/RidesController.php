<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ride;

class RidesController extends Controller
{
    /**
     * Display a listing of the current user's rides.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Query the rides of the current users

        $userRidesAsDriver = Ride::
        where('driverID', Auth::user()->getAuthIdentifier())
            ->get();

        // TODO: Query schreiben
        $userRidesAsPassenger = collect([]);

        $userRides = $userRidesAsDriver->merge($userRidesAsPassenger);

        return view('home', ['userRides' => $userRides]);

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
}
