
<div class="modal fade" id="editPlaceLiveModal" tabindex="-1" aria-labelledby="editPlaceLiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="editPlaceLiveForm" method="post" action="{{ route('add-update-place-lived') }}" class="placeLiveFrom">
            @csrf
            <input type="hidden" class="form-control" name="id" id="editPlaceLiveId">
          <div class="modal-header">
            <h5 class="modal-title" id="editPlaceLiveModalLabel">Edit Place Lived</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3 text-start">
                <select class="form-select" name="place_type" id="editPlaceType">
                    <option value="">Select Type</option>
                    <option value="Hometown">Hometown</option>
                    <option value="Currently Living">Currently Living</option>
                    <option value="Moved">Moved</option>
                </select>
              </div>
            <div class="mb-3 text-start">
              <label class="form-label">Place</label>
              <input type="text" class="form-control" name="place" id="editPlace">
            </div>
            <div class="mb-3 text-start">
              <label class="form-label">Date Moved</label>
              <input type="date" class="form-control" name="date_moved" id="editDateMoved">
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>