@extends('layouts.app')

@section('content')

    @if($retrievedRides->isEmpty())
        <div class="container d-flex justify-content-center">
                <div class="row">
                    <h1>No rides available for your search!</h1>
                </div>
        </div>

        <div class="container d-flex justify-content-center mt-5">
            <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i class="bi bi-search me-2"></i>Return to Search</a>
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
            </tr>
            </thead>
            <tbody>

            @foreach($retrievedRides as $ride)
                <tr>
                    <td>{{$ride->departure}}</td>
                    <td>{{$ride->destination}}</td>
                    <td>{{$ride->departureTime}}</td>
                    <td>{{$ride->price . " €"}}</td>
                    <td>{{$ride->availableSeats}}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>
    @endif


@endsection
