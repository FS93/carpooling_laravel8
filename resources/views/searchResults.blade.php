@extends('layouts.app')

@section('content')


    @if($retrievedRides->isEmpty())
        <div class="container d-flex justify-content-center">
            <div class="row">
                <h1>No rides available for your search!</h1>
            </div>
        </div>

        <div class="container d-flex justify-content-center mt-5">
            <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i
                    class="bi bi-search me-2"></i>Return to Search</a>
        </div>

    @else

        <div id="ridesContainer" class="container">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Departure</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Departure Time</th>
                    <th scope="col">Price</th>
                    <th scope="col">Available Seats</th>
                    @auth
                        <th scope="col">Actions</th>
                    @endauth
                </tr>
                </thead>
                <tbody>

                @auth
                    @foreach($retrievedRides as $ride)
                        <tr>
                            <td>{{$ride->departure}}</td>
                            <td>{{$ride->destination}}</td>
                            <td>{{$ride->departureTime}}</td>
                            <td>{{$ride->price . " €"}}</td>
                            <td>{{$ride->availableSeats}}</td>

                            <td id="columnAction{{$ride->id}}">
                                <!-- Join trigger modal -->
                                <button id="btnJoin{{$ride->id}}" type="button" class="btn btn-primary btn-success" data-bs-toggle="modal"
                                        data-bs-target="#Modal{{$ride->id}}">
                                    Join
                                </button>

                                <!-- Unjoin trigger modal -->
                                <button id="btnUnjoin{{$ride->id}}" type="button" class="btn btn-primary btn-danger visually-hidden" data-bs-toggle="modal"
                                        data-bs-target="#Modal{{$ride->id}}">
                                    Unjoin
                                </button>

                                {{-- Join / Unjoin ride modal start --}}
                                <div class="modal fade" id="Modal{{$ride->id}}" tabindex="-1" aria-labelledby="ModalLabel{{$ride->id}}"
                                     data-bs-backdrop="static" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title h1" id="ModalLabel{{$ride->id}}">Do you want to
                                                        join this ride?</h5>
                                                <button id="btnClose{{$ride->id}}" type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>

                                            <form id="ride_form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body p-4 bg-light">
                                                    <div class="my-2">
                                                        <label for="departure">Departure</label>
                                                        <input type="text" name="departure" id="departure"
                                                               class="form-control" placeholder="Departure"
                                                               value="{{ $ride->departure }}" disabled>
                                                    </div>
                                                    <div class="my-2">
                                                        <label for="destination">Destination</label>
                                                        <input type="text" name="destination" id="destination"
                                                               class="form-control" placeholder="Destination"
                                                               value="{{ $ride->destination }}" disabled>
                                                    </div>
                                                    <div class="my-2">
                                                        <label for="departureTime">Departure Time</label>
                                                        <input type="datetime-local" name="departureTime"
                                                               id="departureTime" class="form-control"
                                                               placeholder="Departure Time"
                                                               value="{{ $ride->departureTime }}" disabled>
                                                    </div>
                                                    <div class="my-2">
                                                        <label for="price">Price</label>
                                                        <input type="number" min="0.00" step="0.01" name="price"
                                                               id="price" class="form-control" placeholder="Price"
                                                               value="{{ $ride->price }}" disabled>
                                                    </div>
                                                    <div class="my-2">
                                                        <label for="availableSeats">Available Seats</label>
                                                        <input type="number" name="availableSeats" id="availableSeats"
                                                               class="form-control" placeholder="Available Seats"
                                                               value="{{ $ride->availableSeats }}" disabled>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button"
                                                        onclick="joinRide({{$ride->id}}, {{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}})"
                                                        id="btnJoinRide{{$ride->id}}Action" class="btn btn-success">Join Ride
                                                </button>

                                                <button type="button"
                                                        onclick="unjoinRide({{$ride->id}}, {{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}})"
                                                        id="btnUnjoinRide{{$ride->id}}Action" class="btn btn-danger visually-hidden">Unjoin Ride
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @endauth

                @guest
                    @foreach($retrievedRides as $ride)
                        <tr>
                            <td>{{$ride->departure}}</td>
                            <td>{{$ride->destination}}</td>
                            <td>{{$ride->departureTime}}</td>
                            <td>{{$ride->price . " €"}}</td>
                            <td>{{$ride->availableSeats}}</td>
                        <tr>
                    @endforeach
                @endguest


                </tbody>
            </table>
        </div>

        <script>


            function joinRide(rideID, userID) {
                console.log("Joined rideID: " + rideID.toString() + ", userID: " + userID.toString())

                $('#Modal' + rideID.toString()).on('show.bs.modal', function (event) {
                    $(this).find("ModalLabel"+rideID.toString()).text('Do you want to leave this ride?')
                })


                $.ajax({
                    url: '{{route('joinRide')}}',
                    method: 'POST',
                    data: {
                        rideID: rideID,
                        userID: userID,
                        _token: '{{csrf_token()}}'
                    },
                    success: function () {
                        // close the modal
                        $("#Modal" + rideID.toString()).hide();
                        $('body').removeClass('modal-open');
                        $(".modal-backdrop").remove();

                        // change the modal title
                        $("#ModalLabel"+rideID.toString()).text("Do you want to leave this ride?");

                        // change the button in the table
                        $("#btnJoin" + rideID.toString()).addClass('visually-hidden');
                        $("#btnUnjoin" + rideID.toString()).removeClass('visually-hidden');

                        // change the button in the modal
                        $("#btnJoinRide" + rideID.toString() + "Action").addClass('visually-hidden');
                        $("#btnUnjoinRide" + rideID.toString() + "Action").removeClass('visually-hidden');

                        // show a success alert
                        $("#ridesContainer").before('<div class="alert alert-success container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">Enjoy your ride!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    },
                    error: function () {
                        // close the modal
                        console.log('Something went wrong');
                        $("#Modal" + rideID.toString()).hide();
                        $('body').removeClass('modal-open');
                        $(".modal-backdrop").remove();

                        // show a warning alert
                        $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">Something went wrong...</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    }
                })
            }

            function unjoinRide(rideID, userID) {

                console.log("Unjoined rideID: " + rideID.toString() + ", userID: " + userID.toString())

                $('#Modal' + rideID.toString()).on('show.bs.modal', function (event) {
                    $(this).find("ModalLabel"+rideID.toString()).text('Do you want to join this ride?')
                })


                $.ajax({
                    url: '{{route('unjoinRide')}}',
                    method: 'POST',
                    data: {
                        rideID: rideID,
                        userID: userID,
                        _token: '{{csrf_token()}}'
                    },
                    success: function () {
                        // close the modal
                        $("#Modal" + rideID.toString()).hide();
                        $('body').removeClass('modal-open');
                        $(".modal-backdrop").remove();



                        // change the modal title
                        $("#ModalLabel"+rideID.toString()).text("Do you want to join this ride?");

                        // change the button in the table

                        $("#btnUnjoin" + rideID.toString()).addClass('visually-hidden');
                        $("#btnJoin" + rideID.toString()).removeClass('visually-hidden');

                        // change the button in the modal

                        $("#btnUnjoinRide" + rideID.toString() + "Action").addClass('visually-hidden');
                        $("#btnJoinRide" + rideID.toString() + "Action").removeClass('visually-hidden');

                        // show a success alert

                        $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">You successfully left this ride!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    },
                    error: function () {
                        // close the modal
                        console.log('Something went wrong');
                        $("#Modal" + rideID.toString()).hide();
                        $('body').removeClass('modal-open');
                        $(".modal-backdrop").remove();

                        // show a warning alert
                        $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">Something went wrong...</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    }
                })
            }
        </script>

    @endif

    @guest
        <div class="container d-flex justify-content-center">
            <div class="row">
                <h1><a href="{{ route('login') }}" class="">Login</a> or <a href="{{ route('register') }}" class="">register</a>
                    to join a ride!</h1>
            </div>
        </div>

        <div class="container d-flex justify-content-center mt-5">
            <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i
                    class="bi bi-search me-2"></i>Return to Search</a>
        </div>
    @endguest

@endsection
