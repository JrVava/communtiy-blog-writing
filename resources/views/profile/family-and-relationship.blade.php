<div class="row mt-4">
    <div class="col-12">

        <div class="card shadow-sm" id="familyInfoFormCard">
            <div class="card-body">
                <!-- Family and Relationship Form -->
                <form action="{{ route('add-update-family-relationship') }}" method="post">
                    @csrf
                    <!-- Family Members Section -->
                    <div class="mb-3 text-start" id="familyMembersSection">
                        <label class="form-label">Family Members</label>
                        <div id="familyMembersList">
                            <div class="input-group mb-3 family-member-group">
                                <select name="family_id[]" class="form-select ms-2">
                                    <option value="">--Select Family Member--</option>
                                    @foreach ($forRelationShips as $forRelationShip)
                                        <option value="{{ $forRelationShip->id }}">{{ $forRelationShip->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select class="form-select ms-2" id="familyRelationship1" name="relationship[]">
                                    <option value="">Select relationship</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Sibling">Sibling</option>
                                    <option value="Child">Child</option>
                                    <option value="Spouse">Spouse</option>
                                    <option value="Friend">Friend</option>
                                </select>
                                <button class="btn btn-danger remove-family-member" type="button">-</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="addFamilyMemberBtn">+ Add Family
                            Member</button>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        @if ($user->familyRelationShip->count() > 0)
            @foreach ($user->familyRelationShip as $familyRelation)
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <button class="dropdown-item edit-button editFamilyRelationShipModal"
                                            type="button" data-bs-toggle="modal"
                                            data-bs-target="#editFamilyRelationShipModal"
                                            data-family_id="{{ $familyRelation->relatedUser->full_name }}"
                                            data-relationship="{{ $familyRelation->relationship }}"
                                            data-family_relationship_id="{{ $familyRelation->id }}">
                                            Edit
                                        </button>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('delete-family-member', ['id' => $familyRelation->id]) }}">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3 text-start">
                            <div class="col-md-6">
                                <label for="full_name" class="form-label fw-bold">Family Member:</label>
                                <p id="full_name">{{ $familyRelation->relatedUser->full_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="relationship" class="form-label fw-bold">Relationship:</label>
                                <p id="relationship">{{ $familyRelation->relationship }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>


<div class="modal fade" id="editFamilyRelationShipModal" tabindex="-1" aria-labelledby="editFamilyRelationShipLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFamilyRelationShipForm" method="post" action="{{ route('add-update-family-relationship') }}"
                class="familyRelationShipFrom">
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
