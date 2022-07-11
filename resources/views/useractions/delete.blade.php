{{-- Delete Modal Trigger --}}
<button type="button" class="btn btn-primary btn-danger" data-bs-toggle="modal"
        data-bs-target="#deleteModal{{$ride->id}}">
    <i class="bi bi-trash me-2"></i>
</button>

{{-- Delete Modal --}}
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
{{-- Delete Modal end --}}
