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

        <div class="container">
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

                            <td>
                                <!-- Join trigger modal -->
                                <button type="button" class="btn btn-primary btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#joinModal{{$ride->id}}">
                                    Join
                                </button>

                                {{-- join ride modal start --}}
                                <div class="modal fade" id="joinModal{{$ride->id}}" tabindex="-1" aria-labelledby="joinModalLabel"
                                     data-bs-backdrop="static" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title h1" id="joinModalLabel"><strong>Do you want to
                                                        join this ride?</strong></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>

                                            <form id="join_ride_form" enctype="multipart/form-data">
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
                                                        id="join_ride_btn" class="btn btn-success">Join Ride
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                {{-- join ride modal end --}}
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
                console.log("rideID: " + rideID.toString() + ", userID: " + userID.toString())
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
