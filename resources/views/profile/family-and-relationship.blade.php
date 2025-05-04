<div class="row mt-4">
    <div class="col-12">

        <div class="card shadow-sm" id="familyInfoFormCard">
            <div class="card-body">
                <!-- Family and Relationship Form -->
                <form action="{{ route('add-update-family-relationship') }}" method="post" class="familyRelationshipForm">
                    @csrf
                    <!-- Family Members Section -->
                    <div class="mb-3 text-start" id="familyMembersSection">
                        <label class="form-label">Family Members</label>
                        <div id="familyMembersList">
                            <div class="mb-3 family-member-group">
                                <div class="row">
                                    <div class="col-6">
                                        <select name="family_id[]" class="form-select ms-2">
                                            <option value="">--Select Family Member--</option>
                                            @foreach ($forRelationShips as $forRelationShip)
                                                <option value="{{ $forRelationShip->id }}">
                                                    {{ $forRelationShip->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <select class="form-select ms-2" id="familyRelationship1" name="relationship[]">
                                            <option value="">Select relationship</option>
                                            <option value="Parent">Parent</option>
                                            <option value="Sibling">Sibling</option>
                                            <option value="Child">Child</option>
                                            <option value="Spouse">Spouse</option>
                                            <option value="Friend">Friend</option>
                                        </select>
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-danger remove-family-member" type="button">-</button>
                                    </div>
                                </div>
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
        @include('profile.previews.famil-relationship-preview')
    </div>
</div>
@include('profile.modals.famil-relationship-modal')
