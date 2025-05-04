@if ($user->familyRelationShip->count() > 0)
    @foreach ($user->familyRelationShip as $familyRelation)
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex mb-4 justify-content-end">
                    
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <button class="dropdown-item edit-button editFamilyRelationShipModal" type="button"
                                    data-bs-toggle="modal" data-bs-target="#editFamilyRelationShipModal"
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
