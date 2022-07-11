{{-- Edit Modal Trigger --}}
<button type="button" class="btn btn-primary btn-warning" data-bs-toggle="modal"
        data-bs-target="#editModal{{$ride->id}}">
    <i class="bi bi-pencil-square me-2"></i>
</button>

{{-- Edit Modal Start --}}
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
{{-- Edit Modal End --}}
