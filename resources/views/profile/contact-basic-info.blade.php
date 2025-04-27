<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm" id="contactInfoFormCard">
            <div class="card-body">
                <!-- Contact and Basic Info Form -->
                <form>
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email address">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Enter phone number">
                    </div>

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

                    <div class="mb-3 text-start">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter address">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="website" placeholder="Enter website URL">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" rows="4" placeholder="Write something about yourself"></textarea>
                    </div>

                    <!-- Social Media URLs -->
                    <div class="mb-3 text-start">
                        <label class="form-label">Social Media URLs</label>
                        <div id="socialMediaUrls">
                            <div class="input-group mb-3 social-media-group">
                                <input type="url" class="form-control" placeholder="Enter Social Media URL">
                                <button class="btn btn-danger remove-social" type="button">-</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="addSocialMediaUrlBtn">+ Add Social Media</button>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>