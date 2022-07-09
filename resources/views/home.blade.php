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

                        {{ \Illuminate\Support\Facades\Auth::user()->firstName . " " . \Illuminate\Support\Facades\Auth::user()->name . \Illuminate\Support\Facades\Auth::user()->destination . __(', you are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div
            class="alert alert-success container alert-dismissible d-flex justify-content-center align-items-center mt-3">
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
            <a class="btn btn-primary btn-lg mb-4" type="button" href=" {{route('search')}} "><i
                    class="bi bi-search me-2"></i>Search</a>
            <a class="btn btn-primary btn-lg mb-4 ms-3" type="button" href=" {{route('home.create')}} "><i
                    class="bi bi-plus-circle me-2"></i>Offer</a>
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

                            <!-- Show trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#showModal">
                                Show
                            </button>

                            <!-- Show Modal -->
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Show Ride Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            This is the ride data
                                            <div class="container">
                                                Driver Name:
                                            </div>
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
                                Edit
                            </button>

                            {{-- edit ride modal start --}}
                            <div class="modal fade" id="editModal{{$ride->id}}" tabindex="-1" aria-labelledby="editModalLabel"
                                 data-bs-backdrop="static" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Ride</h5>
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
                                                    <input type="number" name="availableSeats" id="availableSeats" class="form-control" placeholder="Available Seats" value="{{ $ride->availableSeats }}" required>
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
                                Delete
                            </button>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{$ride->id}}" tabindex="-1" aria-labelledby="deleteModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
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
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    @endif
@endsection
