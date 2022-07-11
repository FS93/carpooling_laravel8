@extends('layouts.app')

@section('content')

    @if($retrievedRides->isEmpty())
        {{--no query results--}}

        <div class="container d-flex justify-content-center">
            <div class="row">
                <h1>No rides available for your search!</h1>
            </div>
        </div>

        <div class="container d-flex justify-content-center mt-3">
            <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i
                    class="bi bi-search me-2"></i>Search</a>
            @auth
                <a class="btn btn-primary btn-lg mb-4 ms-3" type="button" href=" {{route('home.create')}} "><i
                        class="bi bi-plus-circle me-2"></i>Offer</a>
            @endauth
        </div>
    @else
        {{--show query results--}}

        <div id="ridesContainer" class="container">
            <table class="table table-striped">
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

                @guest
                    {{--show table without user actions--}}
                    @foreach($retrievedRides as $ride)
                        <tr>
                            <td>{{$ride->departure}}</td>
                            <td>{{$ride->destination}}</td>
                            <td>{{$ride->departureTime}}</td>
                            <td>{{$ride->price . " €"}}</td>
                            <td>{{$ride->availableSeats}}</td>
                            <td>{{$ride->passengers->count()}}</td>
                        <tr>
                    @endforeach
                @endguest

                @auth
                    {{-- show table with actions, distinguishing
                            - rides where the user is the driver
                            - rides where the user already joined as passenger
                            - other rides
                    --}}

                    @foreach($retrievedRides as $ride)
                        <tr>
                            <td>{{$ride->departure}}</td>
                            <td>{{$ride->destination}}</td>
                            <td>{{$ride->departureTime}}</td>
                            <td>{{$ride->price . " €"}}</td>
                            <td>{{$ride->availableSeats}}</td>
                            <td id="numberPassengersRide{{$ride->id}}">{{$ride->passengers_count}}</td>

                            {{-- user actions --}}
                            @if($ride->driverID == \Illuminate\Support\Facades\Auth::user()->id)
                                {{-- current user is the driver of that ride --}}
                                <td style="width: min-content">
                                    {{-- Show Passenger --}}
                                    @include('useractions.showPassenger')

                                    {{-- Edit Ride --}}
                                    @include('useractions.edit')

                                    {{-- Delete Ride --}}
                                    @include('useractions.delete')
                                </td>

                            @elseif($ride->passengers->contains(\Illuminate\Support\Facades\Auth::user()))
                                {{-- current user is a passenger of that ride --}}
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

                            @else
                                {{-- current user is neither passenger nor driver of that ride --}}
                                <td id="columnAction{{$ride->id}}">

                                    {{-- Show Driver --}}
                                    @include('useractions.showDriver')

                                    {{-- Join/Leave Modal (initially: Join) --}}
                                    <x-join-leave-modal
                                        initialType="join"
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

                            @endif
                        </tr>
                    @endforeach

                @endauth

                </tbody>
            </table>
        </div>

        <script>
            function joinRide(rideID, userID) {
                console.log("Joined rideID: " + rideID.toString() + ", userID: " + userID.toString())

                $('#Modal' + rideID.toString()).on('show.bs.modal', function (event) {
                    $(this).find("ModalLabel" + rideID.toString()).text('Do you want to leave this ride?')
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
                        if (data.joinSuccessful) {
                            // show success alert
                            $("#ridesContainer").before('<div class="alert alert-success container alert-dismissible d-flex justify-content-center align-items-center mt-3">' +
                                '<p class="display-5">Enjoy your ride!</p> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')


                            // change the booked seats in the table
                            $("#numberPassengersRide" + rideID.toString()).html(parseInt($("#numberPassengersRide" + rideID.toString()).html()) + 1);


                            // change the modal title
                            $("#ModalLabel" + rideID.toString()).text("Do you want to leave this ride?");

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
                            // change the modal title
                            $("#ModalLabel" + rideID.toString()).text("Do you want to join this ride?");

                            // change the booked seats in the table
                            $("#numberPassengersRide" + rideID.toString()).html(parseInt($("#numberPassengersRide" + rideID.toString()).html()) - 1);


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
@endsection
