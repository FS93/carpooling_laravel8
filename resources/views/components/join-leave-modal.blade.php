<div>
    {{-- Join Modal Trigger --}}
    <button id="btnJoin{{$rideID}}" type="button"
            class="btn btn-primary btn-success @if($initialType == "leave") visually-hidden @endif" data-bs-toggle="modal"
            data-bs-target="#Modal{{$rideID}}">
        <i class="bi bi-person-plus me-2"></i>
    </button>

    {{-- Unjoin Modal Trigger --}}
    <button id="btnUnjoin{{$rideID}}" type="button" class="btn btn-primary btn-danger @if($initialType == "join") visually-hidden @endif"
            data-bs-toggle="modal"
            data-bs-target="#Modal{{$rideID}}">
        <i class="bi bi-person-dash me-2"></i>
    </button>


    {{-- Join/Leave Modal Start --}}
    <div class="modal fade" id="Modal{{$rideID}}" tabindex="-1"
         aria-labelledby="ModalLabel{{$rideID}}"
         data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h1" id="ModalLabel{{$rideID}}">Do you want
                        to {{ $initialType }} this ride?</h5>
                    <button id="btnClose{{$rideID}}" type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <form id="ride_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="my-2">
                            <label for="departure">Departure</label>
                            <input type="text" name="departure" id="departure"
                                   class="form-control" placeholder="Departure"
                                   value="{{ $departure }}" disabled>
                        </div>
                        <div class="my-2">
                            <label for="destination">Destination</label>
                            <input type="text" name="destination" id="destination"
                                   class="form-control" placeholder="Destination"
                                   value="{{ $destination }}" disabled>
                        </div>
                        <div class="my-2">
                            <label for="departureTime">Departure Time</label>
                            <input type="datetime-local" name="departureTime"
                                   id="departureTime" class="form-control"
                                   placeholder="Departure Time"
                                   value="{{ $departureTime }}" disabled>
                        </div>
                        <div class="my-2">
                            <label for="price">Price</label>
                            <input type="number" min="0.00" step="0.01" name="price"
                                   id="price" class="form-control" placeholder="Price"
                                   value="{{ $price }}" disabled>
                        </div>
                        <div class="my-2">
                            <label for="availableSeats">Available Seats</label>
                            <input type="number" name="availableSeats"
                                   id="availableSeats"
                                   class="form-control" placeholder="Available Seats"
                                   value="{{ $availableSeats }}" disabled>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="button"
                            onclick="joinRide({{$rideID}}, {{$userID}})"
                            id="btnJoinRide{{$rideID}}Action"
                            class="btn btn-success @if($initialType == "leave") visually-hidden @endif">Join Ride
                    </button>

                    <button type="button"
                            onclick="unjoinRide({{$rideID}}, {{$userID}})"
                            id="btnUnjoinRide{{$rideID}}Action"
                            class="btn btn-danger @if($initialType == "join") visually-hidden @endif">Unjoin Ride
                    </button>


                </div>
            </div>
        </div>
    </div>
</div>
