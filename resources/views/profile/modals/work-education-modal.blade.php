<div class="modal fade" id="editWorkPlaceModal" tabindex="-1" aria-labelledby="editWorkPlaceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editWorkPlaceForm" method="post" action="{{ route('add-update-workplace') }}"
                class="workplaceForm">
                @csrf
                <input type="hidden" class="form-control" name="id" id="editWorkplaceId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editWorkPlaceModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-start">
                        <label class="form-label" id="editLabelWorkplace">Workplace</label>
                        <input type="text" class="form-control" name="workplace" id="editWorkplace">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" id="eidtLabelPosition">Position</label>
                        <input type="text" class="form-control" name="position" id="editPosition">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="editStartDate">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" id="editEndDate">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label">City/Town</label>
                        <input type="text" class="form-control" name="city" id="editCity">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="editDescription"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>