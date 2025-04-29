<div class="row mt-4">
    <div class="col-12">
        
        <div class="card shadow-sm" id="familyInfoFormCard">
            <div class="card-body">
                <!-- Family and Relationship Form -->
                <form action="{{ route('add-update-family-relationship') }}" method="post">
                    @csrf
                    {{-- @if(isset())
                    @endif --}}
                    <!-- Family Members Section -->
                    <div class="mb-3 text-start" id="familyMembersSection">
                        <label class="form-label">Family Members</label>
                        <div id="familyMembersList">
                            <div class="input-group mb-3 family-member-group">
                                <select name="family_id[]" class="form-select ms-2">
                                    <option value="">--Select Family Member--</option>
                                    @foreach($forRelationShips as $forRelationShip)
                                    <option value="{{ $forRelationShip->id }}">{{ $forRelationShip->full_name }}</option>
                                    @endforeach
                                </select>
                                <select class="form-select ms-2" id="familyRelationship1" name="relationship[]">
                                    <option value="">Select relationship</option>
                                    <option value="parent">Parent</option>
                                    <option value="sibling">Sibling</option>
                                    <option value="child">Child</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="friend">Friend</option>
                                </select>
                                <button class="btn btn-danger remove-family-member" type="button">-</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="addFamilyMemberBtn">+ Add Family Member</button>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>