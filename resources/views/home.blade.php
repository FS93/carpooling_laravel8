@extends('layouts.app')

@section('content')



    <div id="liveAlertPlaceholder"></div>
{{--    <button type="button" class="btn btn-primary" id="liveAlertBtn">Show live alert</button>--}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ \Illuminate\Support\Facades\Auth::user()->firstName . " " . \Illuminate\Support\Facades\Auth::user()->name . \Illuminate\Support\Facades\Auth::user()->phone . __(', you are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success container alert-dismissible d-flex justify-content-center align-items-center mt-3">
            <p class="display-5">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

@if($userRides->isEmpty())
    <div class="container d-flex justify-content-center">
        <div class="row">
            <h1>{{ \Illuminate\Support\Facades\Auth::user()->firstName . " " . \Illuminate\Support\Facades\Auth::user()->name . ", you currently have no rides." }}</h1>
        </div>
    </div>
@else
    <div class="container d-flex justify-content-center mt-5">
        <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i class="bi bi-search me-2"></i>Search</a>
        <a class="btn btn-primary btn-lg mb-4 ms-3" type="button" href=" {{route('home.create')}} "><i class="bi bi-plus-circle me-2"></i>Offer</a>
    </div>
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Departure</th>
                <th scope="col">Destination</th>
                <th scope="col">Departure Time</th>
                <th scope="col">Price</th>
                <th scope="col">Available Seats</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach($userRides as $ride)
                <tr>
                    <td>{{$ride->departure}}</td>
                    <td>{{$ride->destination}}</td>
                    <td>{{$ride->departureTime}}</td>
                    <td>{{$ride->price . " €"}}</td>
                    <td>{{$ride->availableSeats}}</td>
                    <td style="width: min-content">
                        <form action="{{ route('home.destroy',$ride->id) }}" method="Post">
                            <!-- Show trigger modal -->
                            <button type="button" class="btn btn-primary btn-danger" data-bs-toggle="modal" data-bs-target="#showModal">
                                Show
                            </button>

                            <!-- Show Modal -->
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Show Ride Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            This is the ride data
                                            <div class="container">
                                                Driver Name:
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary me-2" href="{{ route('home.edit',$ride->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')

                            <!-- Delete trigger modal -->
                            <button type="button" class="btn btn-primary btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Delete
                            </button>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Do you really want to delete this ride?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button id="liveAlertBtn" type="submit" class="btn btn-primary btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form></td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endif
@endsection
