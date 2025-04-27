<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Work and Education</h5>
            <button type="button" class="btn btn-light btn-sm shadow-sm" id="addWorkplaceBtn">
                + Add a workplace
            </button>
        </div>
        <div class="card shadow-sm d-none" id="workplaceFormCard">
            <div class="card-body">
                <!-- Work and Education Form -->
                <form>
                    <div class="mb-3 text-start">
                        <label for="workplace" class="form-label">Workplace</label>
                        <input type="text" class="form-control" id="workplace" placeholder="Enter workplace">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" placeholder="Enter position">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="city" class="form-label">City/Town</label>
                        <input type="text" class="form-control" id="city" placeholder="Enter city/town">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="4" placeholder="Enter description"></textarea>
                    </div>

                    <div class="text-start">
                        <button type="button" class="btn btn-light me-2" id="cancelWorkplaceBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
