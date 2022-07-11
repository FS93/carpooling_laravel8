{{-- Show Passenger Modal Trigger --}}
<button type="button" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#showPassengerModal{{$ride->id}}">
    <i class="bi bi-people-fill me-2"></i>
</button>

{{-- Show Passenger Modal Start --}}
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
{{-- Show Passenger Modal End --}}
