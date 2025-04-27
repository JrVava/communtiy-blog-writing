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
                <form>
                    <div class="mb-3 text-start">
                        <label for="place" class="form-label">Place</label>
                        <input type="text" class="form-control" id="place" placeholder="Enter place">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="startDate" class="form-label">Date Moved</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>

                    <div class="text-start">
                        <button type="button" class="btn btn-light me-2" id="cancelPlaceLivedBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
