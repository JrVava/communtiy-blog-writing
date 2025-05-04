<div class="modal fade" id="editFamilyRelationShipModal" tabindex="-1" aria-labelledby="editFamilyRelationShipLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFamilyRelationShipForm" method="post" action="{{ route('add-update-family-relationship') }}"
                class="familyRelationshipForm">
                @csrf
                <input type="hidden" class="form-control" name="id" id="editFamilyRelationShipId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlaceLiveModalLabel">Edit Place Lived</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-start">
                        <label class="form-label">Family Member</label>
                        <input type="text" class="form-control" disabled name="family_id" id="editFamilyId">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label">Relationship</label>
                        <select class="form-select ms-2" id="editRelationShip" name="relationship">
                            <option value="">Select relationship</option>
                            <option value="Parent">Parent</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Child">Child</option>
                            <option value="Spouse">Spouse</option>
                            <option value="Friend">Friend</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>