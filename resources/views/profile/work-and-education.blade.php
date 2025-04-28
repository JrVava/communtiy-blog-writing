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
                <form method="post" action="{{ route('add-update-workplace') }}" class="workplaceForm">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="workplace" class="form-label">Workplace</label>
                        <input type="text" class="form-control" id="workplace" name="workplace"
                            placeholder="Enter workplace">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position"
                            placeholder="Enter position">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="start_date">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="end_date">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="city" class="form-label">City/Town</label>
                        <input type="text" class="form-control" id="city" name="city"
                            placeholder="Enter city/town">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Enter description"></textarea>
                    </div>

                    <div class="text-start">
                        <button type="button" class="btn btn-light me-2" id="cancelWorkplaceBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- If Workplace Available Start Here --}}
        @if ($user->workPlace->count() > 0)
            @foreach ($user->workPlace as $workPlace)
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
                                        <button 
                                        class="dropdown-item edit-button" 
                                        type="button" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editWorkPlaceModal"
                                        data-workplace="{{ $workPlace->workplace }}"
                                        data-position="{{ $workPlace->position }}"
                                        data-start_date="{{ $workPlace->start_date }}"
                                        data-end_date="{{ $workPlace->end_date }}"
                                        data-city="{{ $workPlace->city }}"
                                        data-description="{{ $workPlace->description }}"
                                        data-workplace_id="{{ $workPlace->id }}"
                                      >
                                        Edit
                                      </button>
                                      
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('delete-workplace',['id' => $workPlace->id]) }}">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="currentWork" class="form-label fw-bold">Workplace:</label>
                            <p id="currentWork">{{ $workPlace->workplace }}</p> <!-- Displaying Information -->
                        </div>

                        <div class="mb-3 text-start">
                            <label for="education" class="form-label fw-bold">Position:</label>
                            <p id="education">{{ $workPlace->position }}</p> <!-- Displaying Information -->
                        </div>

                        <div class="mb-3 text-start">
                            <label for="livedIn" class="form-label fw-bold">Start Date:</label>
                            <p id="livedIn">{{ $workPlace->start_date }}</p> <!-- Displaying Information -->
                        </div>

                        <div class="mb-3 text-start">
                            <label for="from" class="form-label fw-bold">End Date:</label>
                            <p id="from">{{ $workPlace->end_date }}A</p> <!-- Displaying Information -->
                        </div>

                        <div class="mb-3 text-start">
                            <label for="maritalStatus" class="form-label fw-bold">City/Town:</label>
                            <p id="maritalStatus">{{ $workPlace->city }}</p> <!-- Displaying Information -->
                        </div>

                        <div class="mb-3 text-start">
                            <label for="contactDetails" class="form-label fw-bold">Description:</label>
                            <p id="description">{{ $workPlace->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        {{-- If Workplace Available End Here --}}
    </div>
</div>



{{-- Model Start Here --}}

<div class="modal fade" id="editWorkPlaceModal" tabindex="-1" aria-labelledby="editWorkPlaceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="editWorkPlaceForm" method="post" action="{{ route('add-update-workplace') }}" class="workplaceForm">
            @csrf
            <input type="hidden" class="form-control" name="id" id="editWorkplaceId">
          <div class="modal-header">
            <h5 class="modal-title" id="editWorkPlaceModalLabel">Edit Workplace</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3 text-start">
              <label class="form-label">Workplace</label>
              <input type="text" class="form-control" name="workplace" id="editWorkplace">
            </div>
            <div class="mb-3 text-start">
              <label class="form-label">Position</label>
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
  