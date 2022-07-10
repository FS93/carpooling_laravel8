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
            <table class="table table-striped table-responsive">
                <thead>
                <tr>
                    <th scope="col">Departure</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Departure Time</th>
                    <th scope="col">Price</th>
                    <th scope="col">Available Seats</th>
                    <th scope="col">Booked Seats</th>
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
                            <td id="numberPassengersRide{{$ride->id}}">{{$ride->passengers_count}}</td>

                            @if($ride->driverID == \Illuminate\Support\Facades\Auth::user()->id)
                                {{-- current user is the driver of that ride --}}
                                <td style="width: min-content">

                                    <!-- Show trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#showPassengerModal{{$ride->id}}">
                                        <i class="bi bi-people-fill me-2"></i>
                                    </button>

                                    <!-- Show Passenger Modal -->

                                    <div class="modal fade" id="showPassengerModal{{$ride->id}}" tabindex="-1"
                                         aria-labelledby="showPassengerModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title h1" id="showPassengerModalLabel">Passenger</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Phone</th>
                                                            <th scope="col">E-Mail</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($ride->passengers as $passenger)
                                                            <tr>
                                                                <td>{{$passenger->firstName . " " . $passenger->name}}</td>
                                                                <td>{{$passenger->phone}}</td>
                                                                <td>{{$passenger->email}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>


                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Edit trigger modal -->
                                    <button type="button" class="btn btn-primary btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{$ride->id}}">
                                        <i class="bi bi-pencil-square me-2"></i>
                                    </button>

                                    {{-- edit ride modal start --}}
                                    <div class="modal fade" id="editModal{{$ride->id}}" tabindex="-1" aria-labelledby="editModalLabel"
                                         data-bs-backdrop="static" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title h1" id="editModalLabel">Edit Ride</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>


                                                <form action="{{ route('home.update', $ride->id) }}" method="POST" id="edit_ride_form" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="emp_id" id="emp_id">
                                                    <input type="hidden" name="emp_avatar" id="emp_avatar">
                                                    <div class="modal-body p-4 bg-light">
                                                        <div class="my-2">
                                                            <label for="departure">Departure</label>
                                                            <input type="text" name="departure" id="departure" class="form-control" placeholder="Departure" value="{{ $ride->departure }}" required>
                                                        </div>
                                                        <div class="my-2">
                                                            <label for="destination">Destination</label>
                                                            <input type="text" name="destination" id="destination" class="form-control" placeholder="Destination" value="{{ $ride->destination }}" required>
                                                        </div>
                                                        <div class="my-2">
                                                            <label for="departureTime">Departure Time</label>
                                                            <input type="datetime-local" name="departureTime" id="departureTime" class="form-control" placeholder="Departure Time" value="{{ $ride->departureTime }}" required>
                                                        </div>
                                                        <div class="my-2">
                                                            <label for="price">Price</label>
                                                            <input type="number" min="0.00" step="0.01" name="price" id="price" class="form-control" placeholder="Price" value="{{ $ride->price }}"required>
                                                        </div>
                                                        <div class="my-2">
                                                            <label for="availableSeats">Available Seats</label>
                                                            <input type="number" min="{{$ride->passengers->count()}}" name="availableSeats" id="availableSeats" class="form-control" placeholder="Available Seats" value="{{ $ride->availableSeats }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" id="edit_ride_btn" class="btn btn-success">Update Ride</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- edit ride modal end --}}

                                    <!-- Delete trigger modal -->
                                    <button type="button" class="btn btn-primary btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{$ride->id}}">
                                        <i class="bi bi-trash me-2"></i>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{$ride->id}}" tabindex="-1" aria-labelledby="deleteModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title h1" id="deleteModalLabel">Delete Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Do you really want to delete this ride?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('home.destroy',$ride->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button id="liveAlertBtn" type="submit"
                                                                class="btn btn-primary btn-danger">Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            @elseif($ride->passengers->contains(\Illuminate\Support\Facades\Auth::user()))
                                {{-- current user is a passenger of that ride --}}
                                    <td style="width: min-content">

                                        <!-- Show trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#showDriverModal{{$ride->id}}">
                                            <i class="bi bi-chat-dots me-2"></i>
                                        </button>

                                        <!-- Show Passenger Modal -->
                                        <div class="modal fade" id="showDriverModal{{$ride->id}}" tabindex="-1" aria-labelledby="showDriverModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title h1" id="showDriverModalLabel">Driver Data</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Phone</th>
                                                                <th scope="col">E-Mail</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>{{$ride->driver->firstName . " " . $ride->driver->name}}</td>
                                                                <td>{{$ride->driver->phone}}</td>
                                                                <td>{{$ride->driver->email}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Unjoin trigger modal -->
                                        <button id="btnUnjoin{{$ride->id}}" type="button" class="btn btn-primary btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#Modal{{$ride->id}}">
                                            <i class="bi bi-person-dash me-2"></i>
                                        </button>

                                        <!-- Join trigger modal -->
                                        <button id="btnJoin{{$ride->id}}" type="button" class="btn btn-primary btn-success visually-hidden" data-bs-toggle="modal"
                                                data-bs-target="#Modal{{$ride->id}}">
                                            <i class="bi bi-person-plus me-2"></i>
                                        </button>

                                        {{-- Unjoin ride modal start --}}
                                        <div class="modal fade" id="Modal{{$ride->id}}" tabindex="-1" aria-labelledby="ModalLabel{{$ride->id}}"
                                             data-bs-backdrop="static" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title h1" id="ModalLabel{{$ride->id}}">Do you want to
                                                            leave this ride?</h5>
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
                                                                onclick="unjoinRide({{$ride->id}}, {{\Illuminate\Support\Facades\Auth::user()->id}})"
                                                                id="btnUnjoinRide{{$ride->id}}Action" class="btn btn-danger">Unjoin Ride
                                                        </button>
                                                        <button type="button"
                                                                onclick="joinRide({{$ride->id}}, {{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}})"
                                                                id="btnJoinRide{{$ride->id}}Action" class="btn btn-success visually-hidden">Join Ride
                                                        </button>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </td>

                            @else
                                 {{-- current user is neither passenger nor driver of that ride --}}
                                <td id="columnAction{{$ride->id}}">

                                    <!-- Show trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#showDriverModal{{$ride->id}}">
                                        <i class="bi bi-chat-dots me-2"></i>
                                    </button>

                                    <!-- Show Driver Modal -->
                                    <div class="modal fade" id="showDriverModal{{$ride->id}}" tabindex="-1" aria-labelledby="showDriverModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title h1" id="showDriverModalLabel">Driver Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Phone</th>
                                                            <th scope="col">E-Mail</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$ride->driver->firstName . " " . $ride->driver->name}}</td>
                                                                <td>{{$ride->driver->phone}}</td>
                                                                <td>{{$ride->driver->email}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Join trigger modal -->
                                    <button id="btnJoin{{$ride->id}}" type="button" class="btn btn-primary btn-success" data-bs-toggle="modal"
                                            data-bs-target="#Modal{{$ride->id}}">
                                        <i class="bi bi-person-plus me-2"></i>
                                    </button>

                                    <!-- Unjoin trigger modal -->
                                    <button id="btnUnjoin{{$ride->id}}" type="button" class="btn btn-primary btn-danger visually-hidden" data-bs-toggle="modal"
                                            data-bs-target="#Modal{{$ride->id}}">
                                        <i class="bi bi-person-dash me-2"></i>
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

                            @endif
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

            <div class="container d-flex justify-content-center mt-5">
                <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i
                        class="bi bi-search me-2"></i>Search</a>
                <a class="btn btn-primary btn-lg mb-4 ms-3" type="button" href=" {{route('home.create')}} "><i
                        class="bi bi-plus-circle me-2"></i>Offer</a>
            </div>
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
                    success: function (data) {
                        // close the modal
                        $("#Modal" + rideID.toString()).hide();
                        $('body').removeClass('modal-open');
                        $(".modal-backdrop").remove();


                        // on success
                        if(data.joinSuccessful) {
                            // show success alert
                            $("#ridesContainer").before('<div class="alert alert-success container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                                '<p class="display-5">Enjoy your ride!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')


                            // change the booked seats in the table
                            $("#numberPassengersRide" + rideID.toString()).html(parseInt($("#numberPassengersRide12").html()) + 1);


                            // change the modal title
                            $("#ModalLabel"+rideID.toString()).text("Do you want to leave this ride?");

                            // change the button in the table
                            $("#btnJoin" + rideID.toString()).addClass('visually-hidden');
                            $("#btnUnjoin" + rideID.toString()).removeClass('visually-hidden');

                            // change the button in the modal
                            $("#btnJoinRide" + rideID.toString() + "Action").addClass('visually-hidden');
                            $("#btnUnjoinRide" + rideID.toString() + "Action").removeClass('visually-hidden');
                        } else { // no more seats available
                            $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                                '<p class="display-5">Sorry, there are no more seats available!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                        }


                    },
                    error: function () {
                        // close the modal
                        console.log('Something went wrong');
                        $("#Modal" + rideID.toString()).hide();
                        $('body').removeClass('modal-open');
                        $(".modal-backdrop").remove();

                        // show a warning alert
                        $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">Something went wrong, please try again.</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
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
                    success: function (data) {
                        // close the modal
                        $("#Modal" + rideID.toString()).hide();
                        $('body').removeClass('modal-open');
                        $(".modal-backdrop").remove();


                        if (data.unjoinSuccessful) {
                            // change the modal title
                            $("#ModalLabel"+rideID.toString()).text("Do you want to join this ride?");

                            // change the booked seats in the table
                            $("#numberPassengersRide" + rideID.toString()).html(parseInt($("#numberPassengersRide12").html()) - 1);


                            // change the button in the table

                            $("#btnUnjoin" + rideID.toString()).addClass('visually-hidden');
                            $("#btnJoin" + rideID.toString()).removeClass('visually-hidden');

                            // change the button in the modal

                            $("#btnUnjoinRide" + rideID.toString() + "Action").addClass('visually-hidden');
                            $("#btnJoinRide" + rideID.toString() + "Action").removeClass('visually-hidden');

                            // show a success alert
                            $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                                '<p class="display-5">You successfully left this ride!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                        } else {
                            $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
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
                        $("#ridesContainer").before('<div class="alert alert-danger container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                            '<p class="display-5">Something went wrong, please try again.</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
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
