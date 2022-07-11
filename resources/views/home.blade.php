@extends('layouts.app')

@section('content')

    {{-- Container for leave alert --}}
    <div id="alertContainer"></div>

    @if ($message = Session::get('success'))
        <div
            class="alert alert-success container alert-dismissible d-flex justify-content-center align-items-center mt-3">
            <p class="display-5">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($futureRidesAsDriver->merge($futureRidesAsPassenger)->isEmpty())
        <div class="container d-flex justify-content-center">
            <div class="row">
                <h1>{{"You currently have no rides." }}</h1>
            </div>
        </div>
    @else

        @if($futureRidesAsDriver->isNotEmpty())

            <div class="container">
                <div class="container d-flex justify-content-center">
                    <div class="row">
                        <h1>{{"Rides as Driver" }}</h1>
                    </div>
                </div>
                <table class="table table-striped" id="tblRidesAsDriver">
                    <thead>
                    <tr>
                        <th scope="col">Departure</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Departure Time</th>
                        <th scope="col">Price</th>
                        <th scope="col">Available Seats</th>
                        <th scope="col">Booked Seats</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($futureRidesAsDriver as $ride)
                        <tr>
                            <td>{{$ride->departure}}</td>
                            <td>{{$ride->destination}}</td>
                            <td>{{$ride->departureTime}}</td>
                            <td>{{$ride->price . " €"}}</td>
                            <td>{{$ride->availableSeats}}</td>
                            <td>{{$ride->passengers->count()}}</td>
                            <td style="width: min-content">

                                {{-- Show Passenger --}}
                                @include('useractions.showPassenger')

                                {{-- Edit Ride --}}
                                @include('useractions.edit')

                                {{-- Delete Ride --}}
                                @include('useractions.delete')

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($futureRidesAsPassenger->isNotEmpty())

            <div class="container" id="cntRidesAsPassenger">
                <div class="container d-flex justify-content-center">
                    <div class="row">
                        <h1>{{"Rides as Passenger" }}</h1>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Departure</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Departure Time</th>
                        <th scope="col">Price</th>
                        <th scope="col">Available Seats</th>
                        <th scope="col">Booked Seats</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($futureRidesAsPassenger as $ride)
                        <tr id="trRide{{$ride->id}}">
                            <td>{{$ride->departure}}</td>
                            <td>{{$ride->destination}}</td>
                            <td>{{$ride->departureTime}}</td>
                            <td>{{$ride->price . " €"}}</td>
                            <td>{{$ride->availableSeats}}</td>
                            <td>{{$ride->passengers->count()}}</td>
                            <td style="width: min-content">

                                {{-- Show Driver --}}
                                @include('useractions.showDriver')

                                {{-- Join/Leave Modal (initially: Leave) --}}
                                <x-join-leave-modal
                                    initialType="leave"
                                    rideID="{{$ride->id}}"
                                    userID="{{\Illuminate\Support\Facades\Auth::user()->id}}"
                                    departure="{{$ride->departure}}"
                                    departureTime="{{$ride->departureTime}}"
                                    destination="{{$ride->destination}}"
                                    price="{{$ride->price}}"
                                    availableSeats="{{$ride->availableSeats}}"
                                >
                                </x-join-leave-modal>

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        @endif

    @endif

    <div class="container d-flex justify-content-center mt-5">
        <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i
                class="bi bi-search me-2"></i>Search</a>
        <a class="btn btn-primary btn-lg mb-4 ms-3" type="button" href=" {{route('home.create')}} "><i
                class="bi bi-plus-circle me-2"></i>Offer</a>
    </div>

    <script>
        function unjoinRide(rideID, userID) {

            console.log("Unjoined rideID: " + rideID.toString() + ", userID: " + userID.toString())

            $('#Modal' + rideID.toString()).on('show.bs.modal', function (event) {
                $(this).find("ModalLabel" + rideID.toString()).text('Do you want to join this ride?')
            })


            $.ajax({
                url: '{{route('unjoinRide')}}',
                method: 'POST',
                data: {
                    rideID: rideID,
                    userID: userID,
                    _token: '{{csrf_token()}}'
                },
                success: function (data) {
                    // close the modal
                    $("#Modal" + rideID.toString()).hide();
                    $('body').removeClass('modal-open');
                    $(".modal-backdrop").remove();


                    if (data.unjoinSuccessful) {
                        // hide row of the unjoined ride
                        if ({{$futureRidesAsPassenger->count()}} == 1) {
                            // hide the whole table for passenger rides
                            $("#cntRidesAsPassenger").hide();
                        } else {
                            // hide only the row for the unjoined ride
                            $("#trRide" + rideID.toString()).hide();
                        }

                        // show a success alert
                        $("#alertContainer").html('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">You successfully left this ride!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    } else {
                        $("#alertContainer").html('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">Sorry, you were not part of this ride!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    }

                },
                error: function () {
                    // close the modal
                    console.log('Something went wrong');
                    $("#Modal" + rideID.toString()).hide();
                    $('body').removeClass('modal-open');
                    $(".modal-backdrop").remove();

                    // show a warning alert
                    $("#alertContainer").html('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                        '<p class="display-5">Something went wrong, please try again.</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                }
            })
        }
    </script>
@endsection
