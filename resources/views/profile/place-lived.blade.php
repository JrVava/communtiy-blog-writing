<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Place Lived</h5>
            <button type="button" class="btn btn-light btn-sm shadow-sm" id="addPlaceLivedBtn">
                + Add a Place
            </button>
        </div>
        <div class="card shadow-sm d-none" id="placeLivedFormCard">
            <div class="card-body">
                <!-- Place Lived Form -->
                <form action="{{route('add-update-place-lived')}}" method="post" class="placeLiveFrom">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="place" class="form-label">Place Type</label>
                        <select class="form-select" name="place_type" id="place_type">
                            <option value="">Select Type</option>
                            <option value="Hometown">Hometown</option>
                            <option value="Currently Living">Currently Living</option>
                            <option value="Moved">Moved</option>
                        </select>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="place" class="form-label">Place</label>
                        <input type="text" class="form-control" name="place" id="place" placeholder="Enter place">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="startDate" class="form-label">Date Moved</label>
                        <input type="date" class="form-control" id="startDate" name="date_moved">
                    </div>

                    <div class="text-start">
                        <button type="button" class="btn btn-light me-2" id="cancelPlaceLivedBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- If Place Lived Available Start Here --}}
       @include('profile.previews.place-lived-preview')
        {{-- If Place Lived Available End Here --}}
    </div>
</div>


{{-- Model Start Here --}}
@include('profile.modals.place-lived-modal')