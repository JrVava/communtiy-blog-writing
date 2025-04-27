<div class="row mt-4">
    <div class="col-12">
        
        <div class="card shadow-sm" id="familyInfoFormCard">
            <div class="card-body">
                <!-- Family and Relationship Form -->
                <form>
                    <div class="mb-3 text-start">
                        <label for="relationshipStatus" class="form-label">Relationship Status</label>
                        <select class="form-select" id="relationshipStatus">
                            <option value="">Select status</option>
                            <option value="single">Single</option>
                            <option value="in_a_relationship">In a Relationship</option>
                            <option value="engaged">Engaged</option>
                            <option value="married">Married</option>
                            <option value="complicated">It's Complicated</option>
                        </select>
                    </div>

                    <!-- Family Members Section -->
                    <div class="mb-3 text-start" id="familyMembersSection">
                        <label class="form-label">Family Members</label>
                        <div id="familyMembersList">
                            <div class="input-group mb-3 family-member-group">
                                <input type="text" class="form-control" placeholder="Enter family member name">
                                <select class="form-select ms-2" id="familyRelationship1">
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